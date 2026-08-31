<template>
    <div class="page-shell">
        <header class="topbar">
            <div class="container topbar-inner">
                <a class="brand" href="/">
                    <div class="brand-mark">S</div>
                    <div>
                        <strong>SimpleCMS</strong>
                        <small>Enterprise</small>
                    </div>
                </a>
                <nav class="nav">
                    <a href="/">首页</a>
                    <a href="/about">关于</a>
                    <a href="/services">服务</a>
                    <a href="/solutions">方案</a>
                    <a href="/products">产品</a>
                    <a href="/cases">案例</a>
                    <a href="/news">新闻</a>
                    <a href="/contact">联系</a>
                </nav>
                <div class="nav-actions">
                    <a class="ghost-btn" href="/contact">联系我们</a>
                    <a class="primary-btn" href="/contact">立即咨询</a>
                </div>
            </div>
        </header>

        <main class="main-shell">
            <section class="hero">
                <div class="container hero-inner">
                    <span class="badge">新闻详情</span>
                    <h1>{{ article.title }}</h1>
                    <div class="meta-row">
                        <span>{{ formattedDate }}</span>
                        <span v-if="article.category">{{ article.category }}</span>
                        <span v-if="article.author">作者：{{ article.author }}</span>
                    </div>
                    <div v-if="article.tags?.length" class="tag-row">
                        <span v-for="tag in article.tags" :key="tag.slug || tag.id" class="tag">{{ tag.name }}</span>
                    </div>
                </div>
            </section>

            <section class="content-section">
                <div class="container content-grid">
                    <article class="article-card" v-html="article.content"></article>

                    <aside class="sidebar">
                        <div class="sidebar-panel">
                            <h3>相关资讯</h3>
                            <a v-for="item in related" :key="item.slug" :href="`/news/${item.slug}`" class="related-item">
                                <span>{{ item.title }}</span>
                                <small>{{ item.date }}</small>
                            </a>
                        </div>
                    </aside>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container footer-inner">
                <div>
                    <strong>{{ company.name }}</strong>
                    <p>深圳市南山区科技园 · 数字产业园</p>
                </div>
                <div>
                    <span>+86 400-888-5200</span>
                    <span>contact@simplecms.cn</span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    company: Object,
    article: Object,
    related: Array,
})

const formattedDate = computed(() => {
    if (!props.article?.date) return ''
    const date = new Date(props.article.date)
    return `${date.getFullYear()} / ${String(date.getMonth() + 1).padStart(2, '0')} / ${String(date.getDate()).padStart(2, '0')}`
})
</script>

<style scoped lang="scss">
$primary: #1d4ed8;
$primary-soft: #eaf2ff;
$text: #101828;
$muted: #667085;
$line: #e5e7eb;
$bg: #f8fafc;

* { box-sizing: border-box; }
.page-shell { background: #fff; color: $text; font-family: "Inter", "PingFang SC", sans-serif; }
.container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
.topbar { position: sticky; top: 0; z-index: 10; background: rgba(255,255,255,0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(17,24,39,0.05); }
.topbar-inner { height: 80px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
.brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: $text; }
.brand strong { display: block; font-size: 18px; }
.brand small { color: $muted; }
.brand-mark { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, $primary, #60a5fa); color: #fff; display: grid; place-items: center; font-weight: 700; }
.nav { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; }
.nav a { text-decoration: none; color: $text; opacity: 0.8; font-size: 14px; }
.nav-actions { display: flex; gap: 12px; align-items: center; }
.primary-btn, .ghost-btn { border-radius: 999px; padding: 12px 22px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
.primary-btn { background: linear-gradient(135deg, $primary, #3b82f6); color: #fff; box-shadow: 0 12px 24px rgba(29,78,216,0.2); }
.ghost-btn { background: #fff; color: $text; border: 1px solid $line; }
.hero { padding: 88px 0 38px; background: linear-gradient(180deg, #f8fbff 0%, #fff 100%); }
.badge { display: inline-flex; align-items: center; padding: 8px 14px; border-radius: 999px; background: $primary-soft; color: $primary; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; }
.hero h1 { margin: 16px 0 12px; font-size: clamp(34px, 4vw, 54px); line-height: 1.2; }
.meta-row { display: flex; align-items: center; gap: 18px; color: $muted; font-size: 14px; flex-wrap: wrap; }
.tag-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 18px; }
.tag { display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; background: $primary-soft; color: $primary; font-size: 12px; font-weight: 600; }
.content-section { padding: 40px 0 90px; background: $bg; }
.content-grid { display: grid; grid-template-columns: minmax(0, 1.8fr) minmax(260px, 0.7fr); gap: 24px; }
.article-card, .sidebar-panel { background: #fff; border: 1px solid $line; border-radius: 24px; box-shadow: 0 14px 32px rgba(15, 23, 42, 0.04); }
.article-card { padding: 32px 28px; }
.article-card :deep(p) { color: #334155; line-height: 2; margin: 0 0 18px; }
.article-card :deep(h2), :deep(h3) { margin: 24px 0 12px; color: $text; }
.sidebar { display: flex; }
.sidebar-panel { padding: 26px 22px; width: 100%; }
.sidebar-panel h3 { margin: 0 0 18px; font-size: 20px; }
.related-item { display: block; padding: 12px 0; border-bottom: 1px solid $line; text-decoration: none; color: $text; }
.related-item:last-child { border-bottom: none; }
.related-item span { display: block; font-weight: 600; }
.related-item small { display: block; margin-top: 4px; color: $muted; }
.footer { background: #0f172a; color: #dbe4f0; padding: 28px 0; border-top: 1px solid rgba(255,255,255,0.08); }
.footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
.footer p, .footer span { display: block; margin: 6px 0 0; color: #a8b5c6; }
@media (max-width: 980px) { .nav { display: none; } .content-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .nav-actions { display: none; } .topbar-inner { justify-content: space-between; } .article-card { padding: 22px 18px; } }
</style>
