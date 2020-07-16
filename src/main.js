import Vue       from 'vue'
import App       from './App.vue'
import VueRouter from 'vue-router';
import routes    from './routes';

Vue.config.productionTip = false;
Vue.config.devtools = true;

Vue.use(VueRouter);
Vue.use(routes);

const router = new VueRouter({

    routes,

});

new Vue({
    router,
  render: h => h(App),
}).$mount('#app');
