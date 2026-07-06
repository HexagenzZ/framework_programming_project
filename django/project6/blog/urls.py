from django.urls import path

from .views import add_comment, category_posts, post_detail, post_list

urlpatterns = [
    path("post/<int:pk>/comment/", add_comment, name="add_comment"),
    path("post/<int:pk>/", post_detail, name="post_detail"),
    path("category/<slug:slug>/", category_posts, name="category_posts"),
    path("", post_list, name="home"),
]
