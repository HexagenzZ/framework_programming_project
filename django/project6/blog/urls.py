from django.urls import path

from .views import add_comment, post_detail, post_list

urlpatterns = [
    path("post/<int:pk>/comment/", add_comment, name="add_comment"),
    path("post/<int:pk>/", post_detail, name="post_detail"),
    path("", post_list, name="home"),
]
