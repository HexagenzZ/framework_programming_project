from django.contrib.auth import get_user_model
from django.test import TestCase
from django.urls import reverse

from .models import Post


class BlogTests(TestCase):
    @classmethod
    def setUpTestData(cls):
        cls.user = get_user_model().objects.create_user(
            username="testuser", email="test@email.com", password="secret"
        )
        cls.post = Post.objects.create(
            title="A good title",
            body="Nice body content",
            author=cls.user,
        )

    def test_post_model(self):
        self.assertEqual(self.post.title, "A good title")
        self.assertEqual(self.post.body, "Nice body content")
        self.assertEqual(self.post.author.username, "testuser")
        self.assertEqual(str(self.post), "A good title")
        self.assertEqual(self.post.get_absolute_url(), "/post/1/")
        self.assertEqual(self.post.read_time, 1)

    def test_read_time_calculation(self):
        long_body = "word " * 300
        post = Post.objects.create(
            title="Long post",
            body=long_body,
            author=self.user,
        )
        self.assertEqual(post.read_time, 2)

    def test_url_exists_at_correct_location_listview(self):
        response = self.client.get("/")
        self.assertEqual(response.status_code, 200)

    def test_url_exists_at_correct_location_detailview(self):
        response = self.client.get("/post/1/")
        self.assertEqual(response.status_code, 200)

    def test_post_listview(self):
        response = self.client.get(reverse("home"))
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, "Nice body content")
        self.assertTemplateUsed(response, "home.html")

    def test_post_detailview(self):
        response = self.client.get(reverse("post_detail", kwargs={"pk": self.post.pk}))
        no_response = self.client.get("/post/100000/")
        self.assertEqual(response.status_code, 200)
        self.assertEqual(no_response.status_code, 404)
        self.assertContains(response, "A good title")
        self.assertTemplateUsed(response, "post_detail.html")

    def test_comment_creation_and_relations(self):
        from .models import Comment
        comment = Comment.objects.create(
            post=self.post,
            author=self.user,
            body="A test comment"
        )
        self.assertEqual(comment.post, self.post)
        self.assertEqual(comment.author, self.user)
        self.assertEqual(comment.body, "A test comment")
        self.assertEqual(str(comment), f"Comment by {self.user.username} on {self.post.title}")

    def test_add_comment_anonymous_user(self):
        url = reverse("add_comment", kwargs={"pk": self.post.pk})
        response = self.client.post(url, {"body": "Anonymous comment"})
        self.assertEqual(response.status_code, 403)

    def test_add_comment_authenticated_user_success(self):
        url = reverse("add_comment", kwargs={"pk": self.post.pk})
        self.client.force_login(self.user)
        response = self.client.post(url, {"body": "My awesome comment"}, HTTP_X_REQUESTED_WITH="XMLHttpRequest")
        self.assertEqual(response.status_code, 201)
        data = response.json()
        self.assertEqual(data["author"], self.user.username)
        self.assertEqual(data["body"], "My awesome comment")
        self.assertIn("created_at", data)

    def test_add_comment_empty_body(self):
        url = reverse("add_comment", kwargs={"pk": self.post.pk})
        self.client.force_login(self.user)
        response = self.client.post(url, {"body": ""}, HTTP_X_REQUESTED_WITH="XMLHttpRequest")
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertEqual(data["error"], "Comment body cannot be empty.")

    def test_category_creation_and_filtering(self):
        from .models import Category
        category = Category.objects.create(name="Tech", slug="tech")
        self.post.category = category
        self.post.save()

        # Test category absolute URL
        self.assertEqual(category.get_absolute_url(), "/category/tech/")

        # Test category list filter page
        url = reverse("category_posts", kwargs={"slug": category.slug})
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, "A good title")
        self.assertContains(response, "Category: <span class=\"filter-category-name\">Tech</span>")

    def test_search_autocomplete(self):
        url = reverse("search_autocomplete")
        
        # Test empty query
        response = self.client.get(url + "?q=")
        self.assertEqual(response.status_code, 200)
        self.assertEqual(len(response.json()["results"]), 0)

        # Test valid query
        response = self.client.get(url + "?q=good")
        self.assertEqual(response.status_code, 200)
        results = response.json()["results"]
        self.assertEqual(len(results), 1)
        self.assertEqual(results[0]["title"], "A good title")
        self.assertEqual(results[0]["url"], "/post/1/")

    def test_like_post_anonymous_user(self):
        url = reverse("like_post", kwargs={"pk": self.post.pk})
        response = self.client.post(url)
        self.assertEqual(response.status_code, 403)

    def test_like_post_authenticated_user_toggle(self):
        url = reverse("like_post", kwargs={"pk": self.post.pk})
        self.client.force_login(self.user)
        
        # Like
        response = self.client.post(url)
        self.assertEqual(response.status_code, 200)
        self.assertTrue(response.json()["liked"])
        self.assertEqual(response.json()["total_likes"], 1)

        # Unlike
        response = self.client.post(url)
        self.assertEqual(response.status_code, 200)
        self.assertFalse(response.json()["liked"])
        self.assertEqual(response.json()["total_likes"], 0)

    def test_bookmark_post_anonymous_user(self):
        url = reverse("bookmark_post", kwargs={"pk": self.post.pk})
        response = self.client.post(url)
        self.assertEqual(response.status_code, 403)

    def test_bookmark_post_authenticated_user_toggle(self):
        url = reverse("bookmark_post", kwargs={"pk": self.post.pk})
        self.client.force_login(self.user)

        # Bookmark
        response = self.client.post(url)
        self.assertEqual(response.status_code, 200)
        self.assertTrue(response.json()["bookmarked"])

        # Unbookmark
        response = self.client.post(url)
        self.assertEqual(response.status_code, 200)
        self.assertFalse(response.json()["bookmarked"])

    def test_post_list_bookmarks_filter(self):
        self.post.bookmarks.add(self.user)
        
        # Another post that is not bookmarked
        unbookmarked_post = Post.objects.create(
            title="Unsaved Post",
            body="Content",
            author=self.user
        )

        url = reverse("home")
        
        # View all (bookmarks filter false)
        response = self.client.get(url)
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, "A good title")
        self.assertContains(response, "Unsaved Post")

        # View bookmarks only
        self.client.force_login(self.user)
        response = self.client.get(url + "?bookmarks=true")
        self.assertEqual(response.status_code, 200)
        self.assertContains(response, "A good title")
        self.assertNotContains(response, "Unsaved Post")
