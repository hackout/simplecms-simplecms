import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';
import { compression } from 'vite-plugin-compression2';
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

export default defineConfig({
    resolve: {
        alias: {
            '@': '/resources/js',
            '@css': '/resources/css',
            '@scss': '/resources/scss',
            '@assets': '/resources/assets',
            '@view': '/resources/views'
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        AutoImport({
            include: [
                /\.[tj]sx?$/,
                /\.vue$/, /\.vue\?vue/,
                /\.md$/,
            ],
            imports: [
                'vue',
            ],
            resolvers: [ElementPlusResolver()],
        }),
        compression({
            threshold: 2000,
            deleteOriginalAssets: false,
            skipIfLargerOrEqual: true,
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: '@use "/resources/scss/var/common.scss" as *;'
            }
        },
    },
    build: {
        chunkSizeWarningLimit: 1000,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString();
                    }
                }
            }
        }
    }
});
