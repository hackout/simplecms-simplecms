<template>
    <div class="frontend-home">
        <header class="topbar">
            <div class="container topbar-inner">
                <div class="brand">
                    <div class="brand-mark">S</div>
                    <div>
                        <strong>SimpleCMS</strong>
                        <small>Enterprise</small>
                    </div>
                </div>
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
                    <div class="hero-copy">
                        <span class="badge">企业数字化解决方案</span>
                        <h1>{{ company.name }}</h1>
                        <h2>{{ company.tagline }}</h2>
                        <p>{{ company.description }}</p>
                        <div class="cta-row">
                            <button class="primary-btn">免费咨询</button>
                            <button class="ghost-btn">查看案例</button>
                        </div>
                        <ul class="meta-list">
                            <li>品牌官网</li>
                            <li>业务管理后台</li>
                            <li>运营增长支持</li>
                        </ul>
                    </div>
                    <div class="hero-panel">
                        <div class="panel-card main-card">
                            <div class="panel-header">
                                <span class="dot red"></span>
                                <span class="dot yellow"></span>
                                <span class="dot green"></span>
                            </div>
                            <div class="panel-body">
                                <div class="mini-stat">
                                    <span>增长指数</span>
                                    <strong>+230%</strong>
                                </div>
                                <div class="chart-bars">
                                    <span v-for="item in 8" :key="item" :style="{ height: `${28 + item * 12}px` }"></span>
                                </div>
                                <div class="panel-grid">
                                    <div>
                                        <small>转化率</small>
                                        <strong>18.6%</strong>
                                    </div>
                                    <div>
                                        <small>效率提升</small>
                                        <strong>3.2x</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="stats-wrap">
                <div class="container stats-grid">
                    <div v-for="(item, idx) in stats" :key="idx" class="stat-card">
                        <strong>{{ item.value }}</strong>
                        <span>{{ item.label }}</span>
                        <small>{{ item.suffix }}</small>
                    </div>
                </div>
            </section>

            <section class="section alt-section">
                <div class="container trust-strip">
                    <div class="trust-copy">
                        <span class="badge light">企业信任</span>
                        <h3>为组织提供更稳、更快、更专业的数字化支撑</h3>
                    </div>
                    <div class="trust-metrics">
                        <div>
                            <strong>99.9%</strong>
                            <span>系统稳定性</span>
                        </div>
                        <div>
                            <strong>7x24</strong>
                            <span>运营支持</span>
                        </div>
                        <div>
                            <strong>48h</strong>
                            <span>响应时间</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="solutions" class="section">
                <div class="container">
                    <div class="section-head">
                        <span class="badge light">解决方案</span>
                        <h3>让业务增长更高效</h3>
                    </div>
                    <div class="service-grid">
                        <article v-for="(service, idx) in services" :key="idx" class="service-card">
                            <div class="icon-wrap">
                                <component :is="service.icon" size="22" />
                            </div>
                            <h4>{{ service.title }}</h4>
                            <p>{{ service.description }}</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section alt-section">
                <div class="container">
                    <div class="section-head">
                        <span class="badge light">价值能力</span>
                        <h3>围绕业务目标构建持续增长的数字基础设施</h3>
                    </div>
                    <div class="value-grid">
                        <article v-for="(item, idx) in valueProps" :key="idx" class="value-card">
                            <div class="value-index">0{{ idx + 1 }}</div>
                            <h4>{{ item.title }}</h4>
                            <p>{{ item.description }}</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section alt-section" id="about">
                <div class="container about-grid">
                    <div class="about-copy">
                        <span class="badge light">为什么选择我们</span>
                        <h3>以企业业务目标为核心</h3>
                        <p>
                            我们结合品牌表达、流程优化、运营增长与后台支撑，为企业提供覆盖网站、管理和增长的统一数字化方案。
                        </p>
                        <ul class="feature-list">
                            <li v-for="(item, idx) in highlights" :key="idx">{{ item }}</li>
                        </ul>
                    </div>
                    <div class="about-panel">
                        <div class="feature-box">
                            <span>适用场景</span>
                            <ul>
                                <li v-for="(item, idx) in solutions" :key="idx">{{ item }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cases" class="section">
                <div class="container">
                    <div class="section-head">
                        <span class="badge light">案例展示</span>
                        <h3>帮助企业实现更好的线上表现</h3>
                    </div>
                    <div class="case-grid">
                        <article v-for="(caseItem, idx) in cases" :key="idx" class="case-card">
                            <div class="case-top">
                                <span>{{ caseItem.category }}</span>
                            </div>
                            <h4>{{ caseItem.name }}</h4>
                            <p>{{ caseItem.summary }}</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="process" class="section alt-section">
                <div class="container">
                    <div class="section-head">
                        <span class="badge light">合作流程</span>
                        <h3>从需求到落地的闭环协作</h3>
                    </div>
                    <div class="process-grid">
                        <div v-for="(item, idx) in process" :key="idx" class="process-card">
                            <strong>{{ item.step }}</strong>
                            <h4>{{ item.title }}</h4>
                            <p>{{ item.description }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section cta-section">
                <div class="container cta-box">
                    <div>
                        <span class="badge light">立即启动</span>
                        <h3>从品牌展示到业务协同，一站式打造数字化企业基础</h3>
                    </div>
                    <button class="primary-btn">预约商务沟通</button>
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
    stats: Array,
    services: Array,
    solutions: Array,
    cases: Array,
    highlights: Array,
    valueProps: Array,
    process: Array,
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

.frontend-home {
    background: #fff;
    color: $text;
    font-family: "Inter", "PingFang SC", sans-serif;
}

.container {
    width: min(1180px, calc(100% - 32px));
    margin: 0 auto;
}

.topbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(17,24,39,0.05);
}

.topbar-inner {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    strong {
        display: block;
        font-size: 18px;
    }
    small {
        color: $muted;
    }
}

.brand-mark {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, $primary, #60a5fa);
    color: #fff;
    display: grid;
    place-items: center;
    font-weight: 700;
}

.nav {
    display: flex;
    align-items: center;
    gap: 28px;
    a {
        color: $text;
        text-decoration: none;
        font-size: 14px;
        opacity: 0.8;
    }
}

.nav-actions, .cta-row {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

button {
    border: 0;
    border-radius: 999px;
    padding: 12px 22px;
    font-size: 14px;
    cursor: pointer;
    transition: .2s ease;
}

.primary-btn {
    background: linear-gradient(135deg, $primary, #3b82f6);
    color: #fff;
    box-shadow: 0 14px 30px rgba(29,78,216,0.25);
}

.ghost-btn {
    background: #fff;
    color: $text;
    border: 1px solid $line;
}

.hero {
    padding: 76px 0 30px;
    background: linear-gradient(180deg, #f8fbff 0%, #fff 100%);
}

.hero-inner {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    align-items: center;
    gap: 32px;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 14px;
    border-radius: 999px;
    background: $primary-soft;
    color: $primary;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.badge.light {
    background: #f3f4f6;
    color: #374151;
}

.hero-copy h1 {
    margin: 16px 0 8px;
    font-size: clamp(38px, 5vw, 62px);
    line-height: 1.1;
}

.hero-copy h2 {
    margin: 0 0 16px;
    font-size: clamp(20px, 2vw, 30px);
    color: #334155;
    font-weight: 600;
}

.hero-copy p {
    margin: 0;
    max-width: 620px;
    color: $muted;
    font-size: 17px;
    line-height: 1.8;
}

.meta-list {
    margin: 28px 0 0;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    list-style: none;
    color: $muted;
    font-size: 14px;
}

.meta-list li::before {
    content: "•";
    color: $primary;
    margin-right: 8px;
}

.hero-panel {
    display: flex;
    justify-content: center;
}

.panel-card {
    width: min(480px, 100%);
    border: 1px solid #edf2f7;
    border-radius: 28px;
    background: #fff;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.08);
    overflow: hidden;
}

.panel-header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 18px;
    background: #f8fafc;
    border-bottom: 1px solid $line;
}

.dot {
    width: 10px;
    height: 10px;
    display: inline-block;
    border-radius: 50%;
}

.dot.red { background: #f87171; }
.dot.yellow { background: #fbbf24; }
.dot.green { background: #34d399; }

.panel-body {
    padding: 26px;
}

.mini-stat {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    color: $muted;
    span { font-size: 14px; }
    strong {
        color: $text;
        font-size: 28px;
    }
}

.chart-bars {
    height: 150px;
    display: flex;
    align-items: end;
    gap: 12px;
    padding: 10px 0 18px;
    span {
        display: block;
        flex: 1;
        background: linear-gradient(180deg, #9ec5ff, #1d4ed8);
        border-radius: 12px 12px 0 0;
        min-height: 26px;
    }
}

.panel-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    div {
        padding: 18px 16px;
        background: #f9fbff;
        border: 1px solid #edf3ff;
        border-radius: 14px;
        small {
            display: block;
            color: $muted;
            margin-bottom: 8px;
        }
        strong {
            font-size: 24px;
        }
    }
}

.stats-wrap {
    padding: 12px 0 36px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 18px;
}

.stat-card {
    background: #fff;
    border: 1px solid $line;
    border-radius: 18px;
    padding: 26px 18px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
    strong {
        display: block;
        font-size: 34px;
        color: $primary;
    }
    span {
        display: block;
        margin-top: 8px;
        color: $muted;
    }
    small {
        color: $text;
        font-weight: 600;
    }
}

.section {
    padding: 80px 0;
}

.alt-section {
    background: #f8fafc;
}

.section-head {
    margin-bottom: 28px;
    h3 {
        margin: 12px 0 0;
        font-size: clamp(26px, 3vw, 38px);
    }
}

.service-grid, .case-grid, .process-grid, .value-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 20px;
}

.service-card, .case-card, .process-card, .value-card {
    background: #fff;
    border: 1px solid $line;
    border-radius: 18px;
    padding: 24px 20px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03);
}

.icon-wrap {
    width: 52px;
    height: 52px;
    display: grid;
    place-items: center;
    border-radius: 16px;
    background: $primary-soft;
    color: $primary;
    margin-bottom: 18px;
}

.service-card h4, .case-card h4, .process-card h4, .value-card h4 {
    margin: 0 0 12px;
    font-size: 20px;
}

.service-card p, .case-card p, .process-card p, .value-card p {
    margin: 0;
    color: $muted;
    line-height: 1.8;
}

.trust-strip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    background: linear-gradient(135deg, #eff6ff, #ffffff);
    border: 1px solid #dfeaf8;
    border-radius: 24px;
    padding: 26px 28px;
}

.trust-copy h3 {
    margin: 12px 0 0;
    font-size: clamp(24px, 2.8vw, 36px);
    line-height: 1.3;
}

.trust-metrics {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 18px;
    flex: 1;
    div {
        background: rgba(255,255,255,0.9);
        border: 1px solid #e3ebfb;
        border-radius: 18px;
        padding: 18px 16px;
        text-align: center;
    }
    strong {
        display: block;
        color: $primary;
        font-size: 28px;
        margin-bottom: 8px;
    }
    span {
        color: $muted;
        font-size: 14px;
    }
}

.value-card {
    background: #fff;
    border: 1px solid $line;
    border-radius: 18px;
    padding: 22px 20px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.02);
}

.value-index {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: $primary-soft;
    color: $primary;
    font-weight: 700;
    margin-bottom: 16px;
}

.about-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 28px;
    align-items: center;
}

.about-copy h3 {
    margin: 12px 0 14px;
    font-size: clamp(28px, 3vw, 42px);
}

.about-copy p {
    margin: 0;
    color: $muted;
    line-height: 2;
}

.feature-list {
    margin: 20px 0 0;
    padding-left: 18px;
    color: $text;
    line-height: 2;
}

.feature-box {
    background: linear-gradient(180deg, #fff, #eef5ff);
    border: 1px solid #dfeafc;
    border-radius: 22px;
    padding: 28px 24px;
    span {
        display: block;
        color: $primary;
        font-weight: 700;
        margin-bottom: 18px;
    }
    ul {
        margin: 0;
        padding-left: 18px;
        line-height: 2;
        color: $text;
    }
}

.case-top {
    margin-bottom: 16px;
    span {
        display: inline-block;
        background: #eef2ff;
        color: #4f46e5;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
    }
}

.process-card strong {
    display: inline-block;
    color: $primary;
    font-size: 22px;
    margin-bottom: 12px;
}

.cta-section {
    padding-top: 20px;
}

.cta-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: linear-gradient(135deg, #0f172a, #1d4ed8);
    border-radius: 28px;
    padding: 32px 34px;
    color: #fff;
    box-shadow: 0 24px 50px rgba(29,78,216,0.22);
    h3 {
        margin: 12px 0 0;
        max-width: 690px;
        font-size: clamp(26px, 3vw, 38px);
        line-height: 1.3;
    }
    .badge.light {
        background: rgba(255,255,255,0.12);
        color: #e7eeff;
    }
    .primary-btn {
        box-shadow: none;
        background: #fff;
        color: #0f172a;
        white-space: nowrap;
    }
}

.footer {
    background: #0f172a;
    color: #dbe4f0;
    padding: 28px 0;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.footer-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    p, span {
        display: block;
        margin: 6px 0 0;
        color: #a8b5c6;
    }
}

@media (max-width: 980px) {
    .hero-inner, .about-grid, .service-grid, .case-grid, .process-grid, .value-grid, .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
    .hero-inner, .about-grid, .trust-strip, .cta-box {
        grid-template-columns: 1fr;
        display: grid;
    }
    .nav {
        display: none;
    }
}

@media (max-width: 640px) {
    .service-grid, .case-grid, .process-grid, .value-grid, .stats-grid, .trust-metrics {
        grid-template-columns: 1fr;
    }
    .topbar-inner {
        justify-content: space-between;
    }
    .nav-actions {
        display: none;
    }
    .cta-box {
        padding: 24px 20px;
    }
}
</style>
