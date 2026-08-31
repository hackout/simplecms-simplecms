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
                        <span class="badge">联系我们</span>
                        <h1>{{ company.name }}</h1>
                        <h2>{{ company.tagline }}</h2>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="container contact-grid">
                    <div class="contact-card">
                        <h3>商务咨询</h3>
                        <p>{{ company.phone }}</p>
                        <p>{{ company.email }}</p>
                        <p>{{ company.address }}</p>
                    </div>
                    <div class="contact-card form-box">
                        <div class="field"><label>公司名称</label><input placeholder="请输入公司名称" /></div>
                        <div class="field"><label>联系人</label><input placeholder="请输入联系人" /></div>
                        <div class="field"><label>邮箱</label><input placeholder="请输入邮箱" /></div>
                        <button class="primary-btn full">提交需求</button>
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
})
</script>

<style scoped lang="scss">
$primary: #1d4ed8;
$primary-soft: #eaf2ff;
$text: #101828;
$muted: #667085;
$line: #e5e7eb;

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
.nav-actions { display: flex; gap: 12px; align-items: center; }
.primary-btn, .ghost-btn { border-radius: 999px; padding: 12px 22px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
.primary-btn { background: linear-gradient(135deg, $primary, #3b82f6); color: #fff; box-shadow: 0 12px 24px rgba(29,78,216,0.2); }
.ghost-btn { background: #fff; color: $text; border: 1px solid $line; }
.hero { padding: 90px 0 40px; background: linear-gradient(180deg, #f8fbff 0%, #fff 100%); }
.badge { display: inline-flex; align-items: center; padding: 8px 14px; border-radius: 999px; background: $primary-soft; color: $primary; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; }
.hero h1 { margin: 16px 0 8px; font-size: clamp(38px, 5vw, 62px); line-height: 1.1; }
.hero h2 { margin: 0; font-size: clamp(20px, 2vw, 30px); color: #334155; font-weight: 600; }
.section { padding: 80px 0; }
.contact-grid { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 24px; }
.contact-card { background: #fff; border: 1px solid $line; border-radius: 22px; padding: 28px 24px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03); }
.contact-card h3 { margin: 0 0 18px; font-size: 28px; }
.contact-card p { margin: 8px 0; color: $muted; line-height: 1.9; }
.form-box { display: grid; gap: 16px; }
.field { display: grid; gap: 8px; }
.field label { font-weight: 600; }
.field input { width: 100%; border: 1px solid $line; border-radius: 12px; padding: 12px 14px; font-size: 14px; }
.full { width: 100%; border: none; }
.footer { background: #0f172a; color: #dbe4f0; padding: 28px 0; border-top: 1px solid rgba(255,255,255,0.08); }
.footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
.footer p, .footer span { display: block; margin: 6px 0 0; color: #a8b5c6; }
@media (max-width: 980px) { .nav { display: none; } .contact-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .nav-actions { display: none; } .topbar-inner { justify-content: space-between; } }
</style>
