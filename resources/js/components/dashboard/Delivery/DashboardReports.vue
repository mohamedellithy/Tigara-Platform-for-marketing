<template>
    <div class="container-body-merchant">
        <div class="row">
            <ul class="reports-tabs">
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/dairy'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_count }}</strong>
                        <p>
                            اجمالى الطلبات
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/dairy'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_dairy_count }}</strong>
                        <p>
                            اجمالى اليومية
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/wait'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_wait_count }}</strong>
                        <p>
                            اجمالى الطلبات المنتظرة
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/process'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_process_count }}</strong>
                        <p>
                            اجمالى الطلبات قيد التنفيذ
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/complete'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_completed_count }}</strong>
                        <p>
                            اجمالى الطلبات مكتملة
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/cancelled'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_cancelled_count }}</strong>
                        <p>
                            اجمالى الطلبات المرفوضة
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/delivery-orders/return'}">
                        <i style="color: #ffa5007d;" class="fas fa-dolly-flatbed"></i>
                        <strong>{{ statics.orders_returned_count }}</strong>
                        <p>
                            اجمالى الطلبات المرتجع
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/show-due-delivery-payments'}">
                        <i style="color: #b8dcb9;" class="fas fa-coins"></i>
                        <strong>{{ statics.total_sales }} <span>USD</span></strong>
                        <p>
                            اجمالى المبيعات
                        </p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/show-due-delivery-payments'}">
                        <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                        <strong>{{ statics.payments_total }} <span>USD</span></strong>
                        <p>
                            اجمالى المدفوعات
                        </p>
                    </router-link>
                </li>
                <li>
                    <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                    <strong>{{ statics.payments_due }} <span>USD</span> </strong>
                    <p>
                        اجمالى المدفوعات المطلوبة
                    </p>
                </li>
                <li>
                    <router-link :to="{path:'/delivery/show-made-delivery-payments'}">
                        <i style="color: #ffccbc;" class="fas fa-money-check-alt"></i>
                        <strong>{{ statics.payments_made }} <span>USD</span></strong>
                        <p>
                            اجمالى المدفوعات المسددة
                        </p>
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h5 class="alert">
                    أخر الطلبات
                </h5>
                <div class="content-tab-orders alert alert-warning">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>كمية الطلب</th>
                                <th>حالة الشحن</th>
                                <th>تاريخ الانشاء</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order,index) in statics.orders" :key="index">
                                <td>{{ order.id }}#</td>
                                <td>{{ order.quantity }} طلبية</td>
                                <td>{{ order.shipping_status_txt }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>
                                    <router-link :to="{path:'/delivery/delivery-show-orders/'+order.id}" class="btn btn-primary btn-sm">عرض الطلب</router-link>
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
    created(){
        let self = this;
        axios.get('/api/delivery-statics').then(function({data}){
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
        margin: 1%;
    }
    .reports-tabs li strong{
        font-size: 15px;
    }
    .reports-tabs li p{
        font-size: 11px;
        padding: 0px 1px;
    }
    .container-body-merchant{
        padding: 2% !important;
    }
}
</style>
