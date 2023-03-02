<template>
    <div class="container-body-merchant">
        <div class="row">
            <ul class="reports-tabs">
                <li>
                    <i style="color: #880e4f42;" class="fas fa-th-large"></i>
                    <strong>{{ statics.products_count }}</strong>
                    <p>المنتجات</p>
                </li>
                <li>
                    <i style="color: #1565c052;" class="fas fa-th-large"></i>
                    <strong>{{ statics.lowstock_products_count }}</strong>
                    <p>المنتجات المنتهية</p>
                </li>
                <li>
                    <i style="color: #ffa5007d;" class="fas fa-shopping-cart"></i>
                    <strong>{{ statics.orders_count }}</strong>
                    <p>
                        اجمالى الطلبات
                    </p>
                </li>
                <li>
                    <i style="color: #b8dcb9;" class="fas fa-pallet"></i>
                    <strong>{{ statics.total_sales }} <span>USD</span></strong>
                    <p>
                        اجمالى المبيعات
                    </p>
                </li>
                <li>
                    <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                    <strong>{{ statics.payments_total }} <span>USD</span></strong>
                    <p>
                        اجمالى المدفوعات
                    </p>
                </li>
                <li>
                    <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                    <strong>{{ statics.payments_due }} <span>USD</span> </strong>
                    <p>
                        اجمالى المدفوعات المطلوبة
                    </p>
                </li>
                <li>
                    <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                    <strong>{{ statics.payments_made }} <span>USD</span></strong>
                    <p>
                        اجمالى المدفوعات المسددة
                    </p>
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
                                <th>المنتج</th>
                                <th>كمية الطلب</th>
                                <th>تاريخ الانشاء</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order,index) in statics.orders" :key="index">
                                <td>{{ order.order_id }}#</td>
                                <td>{{ order.product.name }}</td>
                                <td>{{ order.quantity }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>
                                    <router-link :to="{path:'/merchant/show-product/'+order.product.id}" class="btn btn-primary btn-sm">عرض المنتج</router-link>
                                </td>
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
                                 <td>منتهي</td>
                                <td>
                                    <router-link :to="{path:'/merchant/show-product/'+product.id}" class="btn btn-primary btn-sm">عرض المنتج</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
            statics:{}
        }
    },
    methods:{

    },
    created(){
        let self = this;
        axios.get('/api/merchant-statics').then(function({data}){
            console.log(data);
            self.statics = data;
        }).catch(function({response}){
            console.log(response);
        });
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
</style>
