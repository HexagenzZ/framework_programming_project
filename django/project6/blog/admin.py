from django.contrib import admin

from .models import Category, Comment, Post


class CategoryAdmin(admin.ModelAdmin):
    prepopulated_fields = {"slug": ("name",)}


class PostAdmin(admin.ModelAdmin):
    list_display = (
        "title",
        "category",
        "author",
        "body",
    )


class CommentAdmin(admin.ModelAdmin):
    list_display = (
        "post",
        "author",
        "body",
        "created_at",
    )
    list_filter = ("created_at", "author")


admin.site.register(Post, PostAdmin)
admin.site.register(Comment, CommentAdmin)
admin.site.register(Category, CategoryAdmin)

# Customize Admin branding for a premium look
admin.site.site_header = "Digitalecture Blog Admin"
admin.site.site_title = "Digitalecture Admin Portal"
admin.site.index_title = "Welcome to Digitalecture Blog Management Portal"
