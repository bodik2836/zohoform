// import './bootstrap';

import { createApp, h } from "vue";
import { createInertiaApp } from '@inertiajs/vue3'
import App from './components/layouts/App.vue'

createInertiaApp({
    resolve: name => {
      const pages = import.meta.glob('./components/zoho/**/*.vue', { eager: true })
      let page = pages[`./components/${name}.vue`]
      page.default.layout = page.default.layout || App
      return page
    },
    setup({ el, App, props, plugin }) {
      createApp({ render: () => h(App, props) })
        .use(plugin)
        .mount(el)
    },
  })
