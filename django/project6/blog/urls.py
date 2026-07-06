from django.urls import path

from .views import add_comment, bookmark_post, category_posts, like_post, post_detail, post_list, search_autocomplete

urlpatterns = [
    path("post/<int:pk>/comment/", add_comment, name="add_comment"),
    path("post/<int:pk>/like/", like_post, name="like_post"),
    path("post/<int:pk>/bookmark/", bookmark_post, name="bookmark_post"),
    path("post/<int:pk>/", post_detail, name="post_detail"),
    path("category/<slug:slug>/", category_posts, name="category_posts"),
    path("search/autocomplete/", search_autocomplete, name="search_autocomplete"),
    path("", post_list, name="home"),
]
