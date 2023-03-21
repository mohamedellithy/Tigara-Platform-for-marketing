<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ all_deliveries }} شركة الشحن
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ total_profits }} اجمالى الأرباح
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ total_delivery_profits }} اجمالى أرباح شركات الشحن
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-eye"></i>
                                    {{ total_platform_profits }} اجمالى أرباح المنصة
                                </li>
                                <br/><br/>
                                <li class="filter-item" style="background-color: rgb(255, 234, 234);">
                                    <i class="fas fa-eye"></i>
                                    {{ deliveries.length }} شركة الشحن
                                </li>
                                
                                
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى شركات الشحن" v-model="search" class="form-control search-input"/>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم شركة الشحن</th>
                                <th>اجمالى الطلبات</th>
                                <th>اجمالى المبيعات</th>
                                <th>اجمالى الأرباح</th>
                                <th>اجمالى أرباح شركة الشحن</th>
                                <th>اجمالى أرباح المنصة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(delivery, key) in deliveries" :key="key">
                                <th scope="row">{{ delivery.id }}</th>
                                <td>{{ delivery.name }}</td>
                                <td>{{ delivery.total_orders }} طلبية</td>
                                <td>{{ delivery.total_sales }} USD</td>
                                <td>{{ delivery.total_profits }} USD</td>
                                <td>{{ delivery.total_delivery_profits }} USD</td>
                                <td>{{ delivery.total_platforms_profit_from_delivery_cash }} USD</td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/dashboard/show-delivery/'+delivery.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > deliveries.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/delivery-profites/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/delivery-profites/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
    </div>
</template>
<script>
export default {
    data() {
        return {
            total_delivery_profits:0,
            total_profits:0,
            all_deliveries:0,
            total_platform_profits:0,
            infos:[],
            deliveries: [],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                update_status:0,
                ids:[]
            },
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر'
        };
    },
    methods:{
        FetchDeliveries:function(){
            let self = this;
            axios.get('/api/deliveries',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.deliveries          = self.infos.data;
                self.all_deliveries       = data.all_deliveries;
                self.total_delivery_profits = data.total_delivery_profits;
                self.total_profits    = data.total_profits;
                self.total_platform_profits = data.total_platform_profits;
                console.log(self.deliveries);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created:function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            delivery_profits:true
        };
        this.FetchDeliveries();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {
                    q:search,
                    delivery_profits:true
                };
                axios.get('/api/deliveries/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos                 = [];
                    self.deliveries            = data.data_info;
                    // self.no_active_deliveries  = data.no_active_deliveries;
                    // self.total_profits     = data.total_profits;
                    // self.total_platform_profits = data.total_platform_profits;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
                    delivery_profits:true
                };
                self.FetchDeliveries();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.deliveries.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.deliveries.forEach(function(item){
                    self.selected.splice(self.selected.indexOf(item.id),1);
                });
            }
        }
    }
};
</script>
<style scoped>
.content-page {
    padding: 2%;
}
.actions-btn .btn{
    margin:1%;
}
.filter-bar .filter-results{
    list-style: none;
    padding: 0px
}
.filter-bar .filter-results .filter-item{
    padding: 10px 10px 10px 10px;
    display: inline-block;
    width: auto;
    background-color: #eee;
    margin: 0px 3px;
}
.filter-bar .search-input{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
    margin-top: 34px;
}
.page-item .page-link{
    margin: 9px 0px;
}
.page-item .page-link.active{
    background-color:black;
    color:white;
    border: 1px solid black;
    border-radius: 0px;
}
.page-item .page-link[aria-label='Previous'],
.page-item .page-link[aria-label='Next']
{
    border-radius: 0;
    background-color: orange;
    color: black;
    margin: 10px;
    border: 1px solid orange;
}
</style>
