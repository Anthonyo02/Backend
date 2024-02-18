<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleWithCategoryResource;

class ArticleWithCategoryController extends Controller
{
    public function getArticleWithCategory(int $id): \Illuminate\Http\JsonResponse
{
	$article = Article::with('category')->find($id);
	if (!$article) {
		return response()->json(['message' => 'Article not found'], 404);
	}
	return response()->json(["article" => new ArticleWithCategoryResource($article)]);
}
}
