<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Services\Backend\ArticleCategoryService;
use App\Services\Backend\ArticleService;
use App\Services\Backend\ArticleTagService;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController;

/**
 * 内容管理控制器
 *
 * 负责文章、分类和标签的后台管理逻辑。
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
#[ApiName(name: '内容管理控制器')]
class ArticleController extends BackendController
{
    /**
     * 内容管理首页
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '内容管理')]
    public function index(): InertiaResponse
    {
        return Inertia::render('Content/Index');
    }

    /**
     * 文章列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return JsonResponse
     */
    #[ApiName(name: '审核列表页')]
    public function reviewPage(Request $request): InertiaResponse
    {
        return Inertia::render('Content/Review', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'status' => 'review',
            ],
        ]);
    }

    #[ApiName(name: '文章列表')]
    public function list(Request $request, ArticleService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'status' => 'sometimes|nullable|string|in:draft,review,published,archived',
            'category_id' => 'sometimes|nullable|uuid',
            'page' => 'sometimes|nullable|integer|min:1',
            'limit' => 'sometimes|nullable|integer|min:1|max:200',
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'status.string' => '状态参数不正确',
            'status.in' => '状态参数不正确',
            'category_id.uuid' => '分类参数不正确',
            'page.min' => '页码不能小于1',
            'limit.min' => '每页数量不能小于1',
            'limit.max' => '每页数量不能超过200',
        ];
        $data = $request->validate($rules, $messages);

        return $this->success($service->getList($data));
    }

    /**
     * 创建文章
     */
    #[ApiName(name: '创建文章')]
    public function create(Request $request, ArticleService $service): JsonResponse
    {
        $payload = $request->validate($this->articleRules(), $this->articleMessages());
        $service->create($payload);

        return $this->success();
    }

    /**
     * 更新文章
     */
    #[ApiName(name: '更新文章')]
    public function update(string $id, Request $request, ArticleService $service): JsonResponse
    {
        $rules = $this->articleRules($id);
        $messages = $this->articleMessages();
        $messages['id.exists'] = '文章不存在';

        $validator = Validator::make(array_merge(['id' => $id], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $data = $validator->safe()->only([
            'category_id',
            'title',
            'slug',
            'summary',
            'content',
            'cover',
            'author_id',
            'status',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'is_published',
            'is_top',
            'is_recommended',
            'sort_order',
            'published_at',
            'tag_ids',
        ]);

        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 删除文章
     */
    #[ApiName(name: '删除文章')]
    public function delete(string $id, Request $request, ArticleService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:articles,id',
        ];
        $messages = [
            'id.exists' => '文章不存在',
        ];

        $validator = Validator::make(['id' => $id], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->delete($id);
        return $this->success();
    }

    #[ApiName(name: '提交审核')]
    public function review(string $id, ArticleService $service): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:articles,id'], ['id.exists' => '文章不存在']);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->review($id);

        return $this->success();
    }

    #[ApiName(name: '退回文章')]
    public function reject(string $id, Request $request, ArticleService $service): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:articles,id'], ['id.exists' => '文章不存在']);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $reason = $request->input('reason');
        $service->reject($id, $reason);

        return $this->success();
    }

    #[ApiName(name: '发布文章')]
    public function publish(string $id, ArticleService $service): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:articles,id'], ['id.exists' => '文章不存在']);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->publish($id);

        return $this->success();
    }

    #[ApiName(name: '文章版本列表')]
    public function versions(string $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:articles,id'], ['id.exists' => '文章不存在']);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $article = Article::query()->with('versions')->findOrFail($id);

        $items = $article->versions->map(function ($version) {
            return [
                'id' => $version->id,
                'version_number' => $version->version_number,
                'title' => $version->title,
                'slug' => $version->slug,
                'summary' => $version->summary,
                'content' => $version->content,
                'status' => $version->status,
                'review_note' => $version->review_note,
                'created_at' => $version->created_at,
                'updated_at' => $version->updated_at,
            ];
        })->values()->all();

        return $this->success(['items' => $items]);
    }

    #[ApiName(name: '恢复旧版本')]
    public function restoreVersion(string $id, Request $request, ArticleService $service): JsonResponse
    {
        $validator = Validator::make([
            'id' => $id,
            'version_id' => $request->input('version_id'),
        ], [
            'id' => 'exists:articles,id',
            'version_id' => 'exists:article_versions,id',
        ], [
            'id.exists' => '文章不存在',
            'version_id.exists' => '版本不存在',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->restoreVersion($id, $request->input('version_id'));

        return $this->success();
    }

    /**
     * 分类列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return JsonResponse
     */
    #[ApiName(name: '文章分类列表')]
    public function categoryList(Request $request, ArticleCategoryService $service): JsonResponse
    {
        return $this->success($service->getList($request->all()));
    }

    /**
     * 标签列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return JsonResponse
     */
    #[ApiName(name: '文章标签列表')]
    public function tagList(Request $request, ArticleTagService $service): JsonResponse
    {
        return $this->success($service->getList($request->all()));
    }

    #[ApiName(name: '创建文章分类')]
    public function categoryCreate(Request $request, ArticleCategoryService $service): JsonResponse
    {
        $payload = $request->validate($this->categoryRules(), $this->categoryMessages());
        $service->create($payload);

        return $this->success();
    }

    #[ApiName(name: '更新文章分类')]
    public function categoryUpdate(string $id, Request $request, ArticleCategoryService $service): JsonResponse
    {
        $rules = $this->categoryRules($id);
        $messages = $this->categoryMessages();
        $messages['id.exists'] = '分类不存在';

        $validator = Validator::make(array_merge(['id' => $id], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $data = $validator->safe()->only(['name', 'slug', 'parent_id', 'description', 'is_valid', 'sort_order']);
        $service->update($id, $data);

        return $this->success();
    }

    #[ApiName(name: '删除文章分类')]
    public function categoryDelete(string $id, Request $request, ArticleCategoryService $service): JsonResponse
    {
        $rules = ['id' => 'exists:article_categories,id'];
        $messages = ['id.exists' => '分类不存在'];

        $validator = Validator::make(['id' => $id], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->delete($id);

        return $this->success();
    }

    #[ApiName(name: '创建文章标签')]
    public function tagCreate(Request $request, ArticleTagService $service): JsonResponse
    {
        $payload = $request->validate($this->tagRules(), $this->tagMessages());
        $service->create($payload);

        return $this->success();
    }

    #[ApiName(name: '更新文章标签')]
    public function tagUpdate(string $id, Request $request, ArticleTagService $service): JsonResponse
    {
        $rules = $this->tagRules($id);
        $messages = $this->tagMessages();
        $messages['id.exists'] = '标签不存在';

        $validator = Validator::make(array_merge(['id' => $id], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $data = $validator->safe()->only(['name', 'slug', 'description']);
        $service->update($id, $data);

        return $this->success();
    }

    #[ApiName(name: '删除文章标签')]
    public function tagDelete(string $id, Request $request, ArticleTagService $service): JsonResponse
    {
        $rules = ['id' => 'exists:article_tags,id'];
        $messages = ['id.exists' => '标签不存在'];

        $validator = Validator::make(['id' => $id], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $service->delete($id);

        return $this->success();
    }

    private function articleRules(?string $id = null): array
    {
        return [
            'id' => 'sometimes|nullable|exists:articles,id',
            'category_id' => 'sometimes|nullable|uuid|exists:article_categories,id',
            'title' => $id === null ? 'required|string|max:255' : 'sometimes|nullable|string|max:255',
            'slug' => $id === null
                ? 'required|string|max:255|unique:articles,slug'
                : 'sometimes|nullable|string|max:255|unique:articles,slug,' . $id,
            'summary' => 'sometimes|nullable|string|max:500',
            'content' => 'sometimes|nullable|string',
            'cover' => 'sometimes|nullable|string|max:500',
            'author_id' => 'sometimes|nullable|uuid|exists:managers,id',
            'status' => 'sometimes|nullable|string|in:draft,review,published,archived',
            'seo_title' => 'sometimes|nullable|string|max:255',
            'seo_description' => 'sometimes|nullable|string|max:500',
            'seo_keywords' => 'sometimes|nullable|string|max:255',
            'is_published' => 'sometimes|nullable|boolean',
            'is_top' => 'sometimes|nullable|boolean',
            'is_recommended' => 'sometimes|nullable|boolean',
            'sort_order' => 'sometimes|nullable|integer',
            'published_at' => 'sometimes|nullable|date',
            'tag_ids' => 'sometimes|nullable|array',
            'tag_ids.*' => 'uuid|exists:article_tags,id',
        ];
    }

    private function articleMessages(): array
    {
        return [
            'title.required' => '文章标题不能为空',
            'title.max' => '文章标题最大不能超过255个字符',
            'slug.required' => '文章标识不能为空',
            'slug.unique' => '文章标识已存在',
            'category_id.exists' => '分类不存在',
            'author_id.exists' => '作者不存在',
            'tag_ids.*.exists' => '标签不存在',
        ];
    }

    private function categoryRules(?string $id = null): array
    {
        return [
            'id' => 'sometimes|nullable|exists:article_categories,id',
            'name' => $id === null ? 'required|string|max:100' : 'sometimes|nullable|string|max:100',
            'slug' => $id === null
                ? 'required|string|max:100|unique:article_categories,slug'
                : 'sometimes|nullable|string|max:100|unique:article_categories,slug,' . $id,
            'parent_id' => 'sometimes|nullable|uuid|exists:article_categories,id',
            'description' => 'sometimes|nullable|string|max:500',
            'is_valid' => 'sometimes|nullable|boolean',
            'sort_order' => 'sometimes|nullable|integer',
        ];
    }

    private function categoryMessages(): array
    {
        return [
            'name.required' => '分类名称不能为空',
            'name.max' => '分类名称最大不能超过100个字符',
            'slug.required' => '分类标识不能为空',
            'slug.unique' => '分类标识已存在',
            'parent_id.exists' => '父分类不存在',
        ];
    }

    private function tagRules(?string $id = null): array
    {
        return [
            'id' => 'sometimes|nullable|exists:article_tags,id',
            'name' => $id === null ? 'required|string|max:100' : 'sometimes|nullable|string|max:100',
            'slug' => $id === null
                ? 'required|string|max:100|unique:article_tags,slug'
                : 'sometimes|nullable|string|max:100|unique:article_tags,slug,' . $id,
            'description' => 'sometimes|nullable|string|max:500',
        ];
    }

    private function tagMessages(): array
    {
        return [
            'name.required' => '标签名称不能为空',
            'name.max' => '标签名称最大不能超过100个字符',
            'slug.required' => '标签标识不能为空',
            'slug.unique' => '标签标识已存在',
        ];
    }
}
