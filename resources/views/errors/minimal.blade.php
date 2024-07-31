<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        code {
            font-family: monospace, monospace;
            font-size: 1em
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        code {
            font-family: Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-gray-400 {
            --border-opacity: 1;
            border-color: #cbd5e0;
            border-color: rgba(203, 213, 224, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .border-r {
            border-right-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-xl {
            max-width: 36rem
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .uppercase {
            text-transform: uppercase
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .tracking-wider {
            letter-spacing: .05em
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @-webkit-keyframes spin {
            0% {
                transform: rotate(0deg)
            }

            to {
                transform: rotate(1turn)
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }

            to {
                transform: rotate(1turn)
            }
        }

        @-webkit-keyframes ping {
            0% {
                transform: scale(1);
                opacity: 1
            }

            75%,
            to {
                transform: scale(2);
                opacity: 0
            }
        }

        @keyframes ping {
            0% {
                transform: scale(1);
                opacity: 1
            }

            75%,
            to {
                transform: scale(2);
                opacity: 0
            }
        }

        @-webkit-keyframes pulse {

            0%,
            to {
                opacity: 1
            }

            50% {
                opacity: .5
            }
        }

        @keyframes pulse {

            0%,
            to {
                opacity: 1
            }

            50% {
                opacity: .5
            }
        }

        @-webkit-keyframes bounce {

            0%,
            to {
                transform: translateY(-25%);
                -webkit-animation-timing-function: cubic-bezier(.8, 0, 1, 1);
                animation-timing-function: cubic-bezier(.8, 0, 1, 1)
            }

            50% {
                transform: translateY(0);
                -webkit-animation-timing-function: cubic-bezier(0, 0, .2, 1);
                animation-timing-function: cubic-bezier(0, 0, .2, 1)
            }
        }

        @keyframes bounce {

            0%,
            to {
                transform: translateY(-25%);
                -webkit-animation-timing-function: cubic-bezier(.8, 0, 1, 1);
                animation-timing-function: cubic-bezier(.8, 0, 1, 1)
            }

            50% {
                transform: translateY(0);
                -webkit-animation-timing-function: cubic-bezier(0, 0, .2, 1);
                animation-timing-function: cubic-bezier(0, 0, .2, 1)
            }
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }
        }
    </style>

    <style>
        :root {
            --cms-bg-color: #111827;
            --cms-bg-color-page: #1c2738;
            --cms-bg-color-overlay: rgba(var(--cms-bg-color-page), .75);
            --cms-color-primary: #3366CC;
            --cms-color-primary-hover: #263142;
            --cms-color-success: #28c76f;
            --cms-color-info: #00cfe8;
            --cms-color-warning: #ff9f43;
            --cms-color-error: #ea5455;
            --cms-color-danger: #ea5455;
            --cms-color-primary-rgb: 218, 221, 244;
            --cms-color-success-rgb: 40, 199, 111;
            --cms-color-info-rgb: 0, 207, 232;
            --cms-color-warning-rgb: 255, 159, 67;
            --cms-color-error-rgb: 234, 84, 85;
            --cms-color-danger-rgb: 234, 84, 85;
            --cms-text-primary: #daddf4;
            --cms-text-regular: #a5aac5;
            --cms-text-secondary: #a8aaae;
            --cms-text-placeholder: #a8aaae;
            --cms-text-disabled: #a8aaae;
            --cms-border-color: #dfe2f5;
            --cms-border-color-light: #e4e7ed;
            --cms-border-color-lighter: #ebeef5;
            --cms-border-color-extra-light: #f2f6fc;
            --cms-border-color-dark: #d4d7de;
            --cms-border-color-darker: #cdd0d6;
            --cms-fill-color: #dfe2f5;
            --cms-fill-color-light: #e4e7ed;
            --cms-fill-color-lighter: #ebeef5;
            --cms-fill-color-extra-light: #f2f6fc;
            --cms-fill-color-dark: #d4d7de;
            --cms-fill-color-darker: #cdd0d6;
            --cms-fill-color-blank: #cdd0d6;
            --cms-divider-line: 10px;
            --cms-text-opacity: 0.78;
            --cms-text-opacity-disabled: 0.42;
            --cms-button-height: 38px;
        }

        ;

        @font-face {
            font-family: Corpo;
            font-weight: 600;
            src: url('/assets/font/MOAM91.ttf');
        }

        @font-face {
            font-family: Corpo;
            font-weight: 400;
            src: url('/assets/font/corpoA.ttf');
        }

        @font-face {
            font-family: Corpo;
            font-weight: 100;
            src: url('/assets/font/corpoS.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 400;
            src: url('/assets/font/HarmonyOS_Sans_SC_Regular.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 300;
            src: url('/assets/font/HarmonyOS_Sans_SC_Light.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 500;
            src: url('/assets/font/HarmonyOS_Sans_SC_Medium.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 600;
            src: url('/assets/font/HarmonyOS_Sans_SC_Bold.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 100;
            src: url('/assets/font/HarmonyOS_Sans_SC_Thin.ttf');
        }

        @font-face {
            font-family: HarmonyOS;
            font-weight: 800;
            src: url('/assets/font/HarmonyOS_Sans_SC_Black.ttf');
        }

        html {
            overflow: hidden;
        }

        body {
            font-family: HarmonyOS, Corpo, system-ui, Avenir, "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
                "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
        }

        a {
            color: var(--el-color-primary);
        }

        code {
            border-radius: 2px;
            padding: 2px 4px;
            background-color: var(--el-color-primary-light-9);
            color: var(--el-color-primary);
        }

        .SimpleCMS {
            background-image: radial-gradient(100% 100% at 80% 20%, #0e123a 0%, var(--cms-bg-color) 50%);
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        input {
            filter: none !important;
        }

        .el-button {
            --el-mask-color: rgba(var(--el-color-primary-light-9), .5);
            box-shadow: 0 3px 9px hwb(224.2 5.9% 86.7% / 0.15), 0 0 transparent, 0 0 transparent;
            background-color: hwb(220 20% 20%) !important;
            color: hwb(0 100% 0%) !important;
            padding: 10px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .footer-bg{
            width: 100%;
            height: auto;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        h4{
            margin-top: -20px;
        }
        .footer-bg img{
            width: 100%;
            height: auto;
        }
        .box{
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 400;
            padding-bottom: 50vh;
            box-sizing: border-box;
            color: #d0d4f1c7;
        }
        .code-img{
            position: absolute;
            width: auto;
            height: 40vh;
            bottom: 10vh;
        }
        .code-img img{
            width: auto;
            height: 100%;
        }
    </style>
</head>

<body class="SimpleCMS">
    <div class="box">
        <h1>@yield('title')</h1>
        <h4>@yield('message')</h4>
        <a href="/" class="el-button">返回首页</a>
        <div class="code-img">
            <img src="{{ url('/assets/images/') }}/@yield('code').png" alt="">
        </div>
    </div>
    <div class="footer-bg">
        <img src="{{ url('/assets/images/misc-mask-dark.png') }}" alt="">
    </div>
</body>

</html>
