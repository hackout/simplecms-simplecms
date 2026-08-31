<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

#[ApiName(name: '企业展示首页控制器')]
class HomeController extends BaseController
{
    #[ApiName(name: '企业展示首页')]
    public function index(): InertiaResponse
    {
        return Inertia::render('Frontend/Index', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '让企业数字化效率更高、更稳、更快',
                'description' => '面向企业管理、品牌展示、数字化协同与业务增长的统一解决方案，帮助团队从流程、数据和服务中释放效率。',
                'phone' => '+86 400-888-5200',
                'email' => 'contact@simplecms.cn',
                'address' => '深圳市南山区科技园 · 数字产业园',
            ],
            'stats' => [
                ['label' => '服务客户', 'value' => '680+', 'suffix' => '家'],
                ['label' => '行业覆盖', 'value' => '24', 'suffix' => '个'],
                ['label' => '项目交付', 'value' => '1.8K', 'suffix' => '个'],
                ['label' => '平均增长', 'value' => '230%', 'suffix' => '+'],
            ],
            'services' => [
                [
                    'title' => '企业官网建设',
                    'description' => '品牌网站、产品展示、集团官网与营销落地页，提升企业可信度和销售转化。',
                    'icon' => 'Monitor',
                ],
                [
                    'title' => '数字化管理',
                    'description' => '搭建适配企业流程的管理后台，支持数据、权限、流程和协同协作。',
                    'icon' => 'Files',
                ],
                [
                    'title' => '业务增长方案',
                    'description' => '从品牌传播、转化漏斗到客户运营，形成持续增长的数字化增长闭环。',
                    'icon' => 'TrendingUp',
                ],
                [
                    'title' => '技术支持与运维',
                    'description' => '提供长期运营维护、系统升级、安全保障和用户培训服务，降低管理成本。',
                    'icon' => 'ShieldCheck',
                ],
            ],
            'solutions' => [
                '企业官网与品牌展示',
                '后台管理与业务协同',
                '内容发布与数据看板',
                '客户运营与增长转化',
            ],
            'cases' => [
                [
                    'name' => '智联能源集团',
                    'category' => '能源与制造',
                    'summary' => '统一品牌官网与业务管理系统，提高领导决策效率与全国分支协同效率。',
                ],
                [
                    'name' => '云帆医疗科技',
                    'category' => '医疗健康',
                    'summary' => '优化网站内容发布、用户信息管理与企业形象展示，提升品牌专业度。',
                ],
                [
                    'name' => '河湾软件服务',
                    'category' => '数字服务',
                    'summary' => '定制统一门户与管理后台，提升对外服务效率和客户体验。',
                ],
            ],
            'highlights' => [
                '专业咨询与策略梳理',
                '高可扩展的管理后台架构',
                '敏捷交付与可持续迭代',
                '安全稳定的运营保障',
            ],
            'valueProps' => [
                ['title' => '业务理解', 'description' => '基于企业目标与流程场景，设计真正适合业务发展的数字化方案。'],
                ['title' => '高效落地', 'description' => '从品牌页面到后台管理，采用标准化组件与快速迭代机制加速交付。'],
                ['title' => '可持续迭代', 'description' => '以数据反馈为驱动，持续优化内容、流程和业务增长路径。'],
                ['title' => '长期保障', 'description' => '提供运维、培训和升级支持，确保企业系统稳定高效运行。'],
            ],
            'process' => [
                ['step' => '01', 'title' => '需求梳理', 'description' => '深挖业务场景、功能需求与目标用户。'],
                ['step' => '02', 'title' => '方案设计', 'description' => '输出品牌页面、数据结构和运营流程方案。'],
                ['step' => '03', 'title' => '快速落地', 'description' => '基于已确认方案进行页面和系统快速开发。'],
                ['step' => '04', 'title' => '持续优化', 'description' => '根据运营反馈持续迭代，提升效果和稳定性。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示关于页')]
    public function about(): InertiaResponse
    {
        return Inertia::render('Frontend/About', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '以客户业务目标为中心的数字化服务商',
                'description' => '我们帮助企业搭建品牌展示、业务管理和增长转化的一体化数字化能力，为组织提升决策效率、运营协同与客户体验。',
                'phone' => '+86 400-888-5200',
                'email' => 'contact@simplecms.cn',
                'address' => '深圳市南山区科技园 · 数字产业园',
            ],
            'values' => [
                ['title' => '目标导向', 'description' => '业务目标优先，确保每一项能力和页面都服务于增长与效率提升。'],
                ['title' => '可落地', 'description' => '方案从概念到实现都追求快速验证、低风险落地和实际产出。'],
                ['title' => '长期协作', 'description' => '不仅提供建设能力，更重视持续优化、持续运营和长期增长保障。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示解决方案页')]
    public function solutions(): InertiaResponse
    {
        return Inertia::render('Frontend/Solutions', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '从品牌传播到内部协同的全链路数字化方案',
            ],
            'items' => [
                ['title' => '品牌官网建设', 'description' => '面向企业建立统一品牌表达平台，传递价值、提升信任与增强销售转化。'],
                ['title' => '后台管理系统', 'description' => '统一管理内容、用户、权限、流程与数据，保证企业协同高效且可控。'],
                ['title' => '数据分析看板', 'description' => '汇聚业务经营与运营数据，建立可视化管理闭环，支撑实时决策。'],
                ['title' => '增长营销体系', 'description' => '从流量入口到转化管理，构造覆盖品牌、内容与客户运营的增长闭环。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示服务页')]
    public function services(): InertiaResponse
    {
        return Inertia::render('Frontend/Services', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '围绕企业成长提供从品牌到运营的一体化服务',
            ],
            'items' => [
                ['title' => '品牌策略与官网规划', 'description' => '为企业梳理品牌定位、价值表达和品牌网站规划，建立统一的市场可信基础。'],
                ['title' => '高级定制开发', 'description' => '面向复杂业务需求，定制后台能力、内容模型和运营流程，提升系统适配度。'],
                ['title' => '数字化运营管理', 'description' => '借助数据看板、流程协同和内容管理，实现更高效率的运营闭环。'],
                ['title' => '持续迭代与运维保障', 'description' => '提供长期维护、系统迭代和培训支持，帮助企业持续优化数字化体系。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示案例页')]
    public function cases(): InertiaResponse
    {
        return Inertia::render('Frontend/Cases', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '帮助企业在业务场景中落地真实成效',
            ],
            'items' => [
                ['name' => '智联能源集团', 'industry' => '能源制造', 'summary' => '重构品牌官网与业务管理体系，实现跨区域高效协同与品牌升级。'],
                ['name' => '云帆医疗科技', 'industry' => '医疗健康', 'summary' => '搭建信息化展示和内容管理能力，提升机构专业形象和传播效率。'],
                ['name' => '河湾软件服务', 'industry' => '数字服务', 'summary' => '定制统一门户和运营后台，提升客户服务效率与项目可视化管理能力。'],
                ['name' => '星河物业集团', 'industry' => '地产物业', 'summary' => '整合对外官网、内容发布和内部协同平台，提升运营透明度与管理效率。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示产品页')]
    public function products(): InertiaResponse
    {
        return Inertia::render('Frontend/Products', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '面向企业成长的数字产品与能力组合',
            ],
            'items' => [
                ['name' => 'CMS 内容中台', 'summary' => '统一管理官网、文章、栏目和内容资产，让品牌传播可控、可复用、高效率。'],
                ['name' => '企业协同后台', 'summary' => '连接流程、权限、数据和业务节点，打通组织协同和数据管控。'],
                ['name' => '数据运营看板', 'summary' => '汇总销售、内容、用户和运营指标，支撑精细化决策和增长优化。'],
                ['name' => '品牌数字化服务', 'summary' => '从品牌规划到页面落地，形成真正适配业务的线上增长解决方案。'],
            ],
        ]);
    }

    #[ApiName(name: '企业展示新闻页')]
    public function news(): InertiaResponse
    {
        return Inertia::render('Frontend/News', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '企业数字化趋势与实践洞察',
            ],
            'items' => $this->publishedArticles(),
        ]);
    }

    #[ApiName(name: '企业展示新闻详情页')]
    public function newsDetail(string $slug): InertiaResponse
    {
        $items = $this->publishedArticles();
        $article = collect($items)->firstWhere('slug', $slug) ?? $items[0] ?? [
            'slug' => $slug,
            'title' => '文章未找到',
            'summary' => '当前文章不存在或尚未发布。',
            'date' => now()->toDateString(),
            'content' => '<p>当前文章不存在或尚未发布。</p>',
        ];

        return Inertia::render('Frontend/NewsDetail', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '企业数字化趋势与实践洞察',
            ],
            'article' => $article,
            'related' => collect($items)->reject(fn ($item) => ($item['slug'] ?? null) === ($article['slug'] ?? null))->take(3)->values()->all(),
        ]);
    }

    #[ApiName(name: '企业展示联系页')]
    public function contact(): InertiaResponse
    {
        return Inertia::render('Frontend/Contact', [
            'company' => [
                'name' => 'SimpleCMS Enterprise',
                'tagline' => '让企业数字化从一个想法开始，走向持续增长',
                'phone' => '+86 400-888-5200',
                'email' => 'contact@simplecms.cn',
                'address' => '深圳市南山区科技园 · 数字产业园',
            ],
        ]);
    }

    private function publishedArticles(): array
    {
        $articles = \App\Models\Article::query()
            ->with(['category', 'author', 'tags'])
            ->where('is_published', true)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return $articles->map(function ($article) {
            return [
                'id' => $article->id,
                'slug' => $article->slug,
                'title' => $article->title,
                'summary' => $article->summary ?: strip_tags($article->content ?? ''),
                'date' => $article->published_at?->toDateString() ?? $article->created_at?->toDateString(),
                'content' => $article->content ?: '<p>暂无正文内容。</p>',
                'category' => $article->category?->name,
                'category_slug' => $article->category?->slug,
                'author' => $article->author?->name ?? $article->author?->account,
                'tags' => $article->tags->map(fn ($tag) => [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                ])->values()->all(),
                'seo_title' => $article->seo_title ?? $article->title,
                'seo_description' => $article->seo_description ?? $article->summary,
                'seo_keywords' => $article->seo_keywords,
            ];
        })->values()->all();
    }
}
