from django.http import JsonResponse
from django.shortcuts import get_object_or_404, render

from .models import Comment, Post


def post_list(request):
    posts = Post.objects.all()
    return render(request, "home.html", {"posts": posts})


def post_detail(request, pk):
    post = get_object_or_404(Post, pk=pk)
    comments = post.comments.all().order_by("created_at")
    return render(request, "post_detail.html", {"post": post, "comments": comments})


def add_comment(request, pk):
    if request.method == "POST":
        if not request.user.is_authenticated:
            return JsonResponse({"error": "You must be logged in to comment."}, status=403)

        post = get_object_or_404(Post, pk=pk)
        body = request.POST.get("body", "").strip()

        if not body:
            return JsonResponse({"error": "Comment body cannot be empty."}, status=400)

        comment = Comment.objects.create(
            post=post,
            author=request.user,
            body=body
        )

        return JsonResponse({
            "id": comment.id,
            "author": comment.author.username,
            "body": comment.body,
            "created_at": comment.created_at.strftime("%b. %d, %Y, %I:%M %p")
        }, status=201)

    return JsonResponse({"error": "Invalid request method."}, status=405)
