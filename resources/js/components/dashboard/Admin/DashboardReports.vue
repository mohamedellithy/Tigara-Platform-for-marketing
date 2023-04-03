<template>
    <div class="container-body-merchant">
        <div class="row">
            <ul class="reports-tabs">
                <li>
                    <router-link :to="{path:'/dashboard/merchants'}">
                        <i style="color: #880e4f42;" class="fas fa-users"></i>
                        <strong>{{ statics.merchants_count }}</strong>
                        <p>التجار</p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/marketers'}">
                        <i style="color: #1565c052;" class="fas fa-user-tie"></i>
                        <strong>{{ statics.marketers_count }}</strong>
                        <p>المسوقين</p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/deliveries'}">
                        <i style="color: #ffa5007d;" class="fas fa-shipping-fast"></i>
                        <strong>{{ statics.deliveries_count }}</strong>
                        <p>
                            شركات الشحن
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/products'}">
                        <i style="color: #b8dcb9;"  class="fas fa-box"></i>
                        <strong>{{ statics.products_count }}</strong>
                        <p>
                            المنتجات
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/orders'}">
                        <i style="color: #ffccbc;" class="fas fa-pallet"></i>
                        <strong>{{ statics.orders_count }}</strong>
                        <p>
                            الطلبات
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/orders'}">
                        <i style="color: #ffccbc;"  class="fas fa-coins"></i>
                        <strong>{{ statics.total_sales }} <span>MRU</span></strong>
                        <p>
                            اجمالى المبيعات
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/dashboard/orders'}">
                        <i style="color: #ffccbc;"  class="fas fa-coins"></i>
                        <strong>{{ statics.total_sale_profits }} <span>MRU</span></strong>
                        <p>
                            اجمالى أرباح المبيعات
                        </p>
                    </router-link>
                </li>

                <li>
                    <router-link :to="{path:'/dashboard/orders'}">
                        <i style="color: #ffccbc;"  class="fas fa-coins"></i>
                        <strong>{{ statics.total_from_delivery_profits }} <span>MRU</span></strong>
                        <p>
                            اجمالى أرباح الشحن
                        </p>
                    </router-link>
                </li>

                <li>
                    <router-link :to="{path:'/dashboard/orders'}">
                        <i style="color: #ffccbc;"  class="fas fa-coins"></i>
                        <strong>{{ statics.all_profits }} <span>MRU</span></strong>
                        <p>
                            اجمالى الأرباح
                        </p>
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h5 class="alert">
                    أخر الطلبات
                </h5>
                <div class="content-tab-orders alert alert-warning">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المسوق</th>
                                <th>تاريخ الانشاء</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order,index) in statics.orders" :key="index">
                                <td>{{ order.id }}#</td>
                                <td>{{ order.marketer.name }}</td>
                                <td>{{ order.created_at }}</td>
                                <th>
                                    <router-link :to="{path:'/dashboard/show-order/'+order.id}" class="btn btn-primary btn-sm">عرض الطلبات</router-link>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="alert">المنتجات المنتهية</h5>
                <div class="content-tab-products alert alert-primary">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم المنتج</th>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in statics.products" :key="index">
                                <td># {{ product.id }}</td>
                                <td> {{ product.name }}</td>
                                 <td>{{ product.quantity }}</td>
                                <td>
                                    <router-link :to="{path:'/dashboard/show-product/'+product.id}" class="btn btn-primary btn-sm">عرض المنتج</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
import imageLoadNotFound from '@/img/image_processing20200627-19092-c2s8xo.gif';
export default {
    components: {
        imageLoadNotFound
    },
    data(){
        return{
            imageLoadNotFound,
            statics:{},
            loading:true
        }
    },
    methods:{

    },
    created(){
        let self = this;
        axios.get('/api/dashboard-statics').then(function({data}){
            console.log(data);
            self.statics = data;
        }).catch(function({response}){
            console.log(response);
        });
    },
    mounted:function(){
        let self = this;
        setTimeout(() => {
            self.loading = false;
        }, 1000);
    }
}
</script>
<style scoped>
.container-body-merchant{
    padding: 4%;
}
.reports-tabs{
    list-style: none;
}
.reports-tabs li{
    display:inline-block;
    background-color:white;
    padding:10px;
    margin: 2%;
    min-width: 20%;
    box-shadow: 15px 23px 18px 14px #eee;
    position: relative;
    /* text-align: center; */
}
.reports-tabs li i
{
    font-size: 50px;
    padding: 12px;
    margin: auto;
    color: gray;
}
.reports-tabs li p{
    text-align: right;
    padding: 0px 10px;
    font-weight: bold;
}
.reports-tabs li strong{
    font-size: 26px;
    color: rgb(55 51 51 / 85%);
    position: absolute;
    left: 10%;
    top: 20%;
}
.content-tab-orders{
    /* background-color: wheat;
    padding: 21px;
    box-shadow: 0px 16px 15px 16px #eee; */
    border-radius: 0px;
    box-shadow: 0px 2px 27px 16px #e5e5e5;
    border:0px solid #eee;
}
.content-tab-products{

    border-radius: 0px;
    box-shadow: 0px 2px 27px 16px #e5e5e5;
    border:0px solid #eee;
}
.content-tab-products table
{
    border-bottom: 1px solid #9bcbfb;
}
li strong span{
    font-size: 13px;
    color: red;
}
@media(max-width:1000px){
    .reports-tabs li{
        min-width: 45%;
        box-shadow: 0px 0px 0px 0px !important;
    }
    .reports-tabs li strong{
        font-size: 15px;
    }
    .reports-tabs li p{
        font-size: 11px;
    }
}
</style>
