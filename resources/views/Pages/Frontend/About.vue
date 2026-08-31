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

        <main>
            <section class="hero">
                <div class="container hero-inner">
                    <div>
                        <span class="badge">关于我们</span>
                        <h1>{{ company.name }}</h1>
                        <h2>{{ company.tagline }}</h2>
                        <p>{{ company.description }}</p>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="container values-grid">
                    <article v-for="(item, idx) in values" :key="idx" class="value-card">
                        <div class="value-index">0{{ idx + 1 }}</div>
                        <h3>{{ item.title }}</h3>
                        <p>{{ item.description }}</p>
                    </article>
                </div>
            </section>

            <section class="section alt-section">
                <div class="container features-layout">
                    <div class="feature-copy">
                        <span class="badge light">我们的能力</span>
                        <h3>把业务目标转化为系统能力和持续增长路径</h3>
                        <p>我们结合品牌、业务、数据与协同场景，设计企业数字化基础能力，帮助组织把流程、信息和服务统一在一套可持续运营的框架中。</p>
                    </div>
                    <div class="feature-list-box">
                        <ul>
                            <li>品牌与官网战略设计</li>
                            <li>后台管理系统搭建</li>
                            <li>内容运营与协同流程</li>
                            <li>业务增长与转化支持</li>
                            <li>长期运维与持续优化</li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container footer-inner">
                <div>
                    <strong>{{ company.name }}</strong>
                    <p>{{ company.address }}</p>
                </div>
                <div>
                    <span>{{ company.phone }}</span>
                    <span>{{ company.email }}</span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
const props = defineProps({
    company: Object,
    values: Array,
})
</script>

<style scoped lang="scss">
$primary: #1d4ed8;
$primary-soft: #eaf2ff;
$text: #101828;
$muted: #667085;
$line: #e5e7eb;
$bg: #f5f7fb;

* { box-sizing: border-box; }

.page-shell { background: #fff; color: $text; font-family: "Inter", "PingFang SC", sans-serif; }
.container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
.topbar { position: sticky; top: 0; z-index: 10; background: rgba(255,255,255,0.85); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(17,24,39,0.05); }
.topbar-inner { height: 80px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
.brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: $text; }
.brand strong { display: block; font-size: 18px; }
.brand small { color: $muted; }
.brand-mark { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, $primary, #60a5fa); color: #fff; display: grid; place-items: center; font-weight: 700; }
.nav { display: flex; align-items: center; gap: 28px; }
.nav a { text-decoration: none; color: $text; opacity: 0.8; font-size: 14px; }
.nav-actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
.primary-btn, .ghost-btn { border-radius: 999px; padding: 12px 22px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
.primary-btn { background: linear-gradient(135deg, $primary, #3b82f6); color: #fff; box-shadow: 0 12px 24px rgba(29,78,216,0.2); }
.ghost-btn { background: #fff; color: $text; border: 1px solid $line; }
.hero { padding: 90px 0 40px; background: linear-gradient(180deg, #f8fbff 0%, #fff 100%); }
.hero-inner { display: grid; grid-template-columns: 1fr; }
.badge { display: inline-flex; align-items: center; padding: 8px 14px; border-radius: 999px; background: $primary-soft; color: $primary; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; }
.badge.light { background: #f3f4f6; color: #374151; }
.hero h1 { margin: 16px 0 8px; font-size: clamp(38px, 5vw, 62px); line-height: 1.1; }
.hero h2 { margin: 0 0 16px; font-size: clamp(20px, 2vw, 30px); color: #334155; font-weight: 600; }
.hero p { max-width: 700px; margin: 0; color: $muted; line-height: 1.9; font-size: 17px; }
.section { padding: 80px 0; }
.alt-section { background: #f8fafc; }
.values-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
.value-card { background: #fff; border: 1px solid $line; border-radius: 20px; padding: 28px 22px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03); }
.value-index { display: inline-flex; width: 42px; height: 42px; border-radius: 12px; background: $primary-soft; color: $primary; align-items: center; justify-content: center; font-weight: 700; margin-bottom: 16px; }
.value-card h3 { margin: 0 0 12px; font-size: 22px; }
.value-card p { margin: 0; line-height: 1.8; color: $muted; }
.features-layout { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 28px; align-items: center; }
.feature-copy h3 { margin: 12px 0 14px; font-size: clamp(28px, 3vw, 42px); }
.feature-copy p { margin: 0; color: $muted; line-height: 2; }
.feature-list-box { background: linear-gradient(180deg, #fff, #eef5ff); border: 1px solid #dfeafc; border-radius: 22px; padding: 28px 24px; }
.feature-list-box ul { margin: 0; padding-left: 18px; color: $text; line-height: 2.2; }
.footer { background: #0f172a; color: #dbe4f0; padding: 28px 0; border-top: 1px solid rgba(255,255,255,0.08); }
.footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
.footer p, .footer span { display: block; margin: 6px 0 0; color: #a8b5c6; }
@media (max-width: 980px) {
  .nav { display: none; }
  .values-grid, .features-layout { grid-template-columns: 1fr; display: grid; }
}
@media (max-width: 640px) {
  .nav-actions { display: none; }
  .topbar-inner { justify-content: space-between; }
}
</style>
