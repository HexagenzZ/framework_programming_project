from django.http import JsonResponse
from django.shortcuts import get_object_or_404, render

from .models import Category, Comment, Post


def post_list(request):
    show_bookmarks = request.GET.get("bookmarks") == "true"
    if show_bookmarks and request.user.is_authenticated:
        posts = Post.objects.filter(bookmarks=request.user)
    else:
        posts = Post.objects.all()
    return render(request, "home.html", {"posts": posts, "show_bookmarks": show_bookmarks})


def post_detail(request, pk):
    post = get_object_or_404(Post, pk=pk)
    comments = post.comments.all().order_by("created_at")
    return render(request, "post_detail.html", {"post": post, "comments": comments})


def category_posts(request, slug):
    category = get_object_or_404(Category, slug=slug)
    posts = Post.objects.filter(category=category)
    return render(request, "home.html", {"posts": posts, "category": category})


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


def search_autocomplete(request):
    query = request.GET.get("q", "").strip()
    results = []
    if query:
        posts = Post.objects.filter(title__icontains=query)[:5]
        for post in posts:
            results.append({
                "id": post.id,
                "title": post.title,
                "url": post.get_absolute_url()
            })
    return JsonResponse({"results": results})


def like_post(request, pk):
    if request.method == "POST":
        if not request.user.is_authenticated:
            return JsonResponse({"error": "You must be logged in to like posts."}, status=403)

        post = get_object_or_404(Post, pk=pk)
        if post.likes.filter(id=request.user.id).exists():
            post.likes.remove(request.user)
            liked = False
        else:
            post.likes.add(request.user)
            liked = True

        return JsonResponse({
            "liked": liked,
            "total_likes": post.likes.count()
        })

    return JsonResponse({"error": "Invalid request method."}, status=405)


def bookmark_post(request, pk):
    if request.method == "POST":
        if not request.user.is_authenticated:
            return JsonResponse({"error": "You must be logged in to bookmark posts."}, status=403)

        post = get_object_or_404(Post, pk=pk)
        if post.bookmarks.filter(id=request.user.id).exists():
            post.bookmarks.remove(request.user)
            bookmarked = False
        else:
            post.bookmarks.add(request.user)
            bookmarked = True

        return JsonResponse({
            "bookmarked": bookmarked
        })

    return JsonResponse({"error": "Invalid request method."}, status=405)
