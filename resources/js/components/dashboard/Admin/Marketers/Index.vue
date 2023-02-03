<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div v-if="Object.keys(this.errors).length !== 0" class="col-12 container-errors">
                            <div class="alert alert-danger">
                                <ul>
                                    <li v-for="(error,index) in errors" :key="index"> {{ error[0] }}</li>
                                </ul>
                            </div>
                        </div>
                        <div v-if="this.success" class="col-12 container-errors">
                            <div class="alert alert-success">
                                <p>{{ success }}</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button @click="TruncateMarketers()" class="btn btn-danger btn-sm">
                                        حذف الكل
                                    </button>
                                    <button @click="DeleteSelectedMarketers()" class="btn btn-primary btn-sm"  :disabled="(selected.length == 0)">
                                        حذف المحدد
                                        <template v-if="selected.length != 0">
                                            ( {{ selected.length }} )
                                        </template>
                                    </button>
                                    <button @click="ShowModelUpdateStatus" class="btn btn-warning btn-sm"  :disabled="(selected.length == 0)">
                                        تحديث الحالة
                                    </button>
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ marketers.length }} مسوق
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ active_marketer }} مفعل
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                     {{ no_active_marketer }} غير مفعل
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى المسوقين" v-model="search" class="form-control search-input"/>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>
                                    <input class="" type="checkbox" v-model="selected_all"/>
                                </th>
                                <th>#</th>
                                <th>اسم المسوق</th>
                                <th>البريدالالكترونى</th>
                                <th>رقم الجوال</th>
                                <th>المنتجات المميزة</th>
                                <th>حالة المسوق</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(marketer, key) in marketers" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="marketer.id" :checked="selected.indexOf(marketer.id) != -1"/>
                                </th>
                                <th scope="row">{{ marketer.id }}</th>
                                <td>{{ marketer.name }}</td>
                                <td>{{ marketer.email }}</td>
                                <td>{{ marketer.phone }}</td>
                                <td>{{ marketer.feature_products }} منتج</td>
                                <td>{{ marketer.status_text }}</td>
                                <td class="actions-btn">
                                    <button @click="DeleteMarketer(marketer.id,marketer.name)" class="btn btn-danger btn-sm">
                                        حذف
                                    </button>
                                    <router-link :to="{path:'/dashboard/add-products-marketer/'+marketer.id}"  class="btn btn-info btn-sm">
                                        تحديد منتجات
                                    </router-link>
                                    <router-link :to="{path:'/dashboard/show-marketer/'+marketer.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > marketers.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/marketers/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/marketers/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                    <!--Table-->
                </div>
                <!-- Modal -->
                <div v-show="this.showModel == true " id="exampleModalLive" class="modal fade " :class="[ this.showModel == true ? 'show' : '' ]" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" :style="`padding-right: 17px; display:block;padding-top: 10%;z-index: 100000;background: #0000001f;`">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">تحديث الحالة المسوق</h5>
                        </div>
                        <div class="modal-body">
                            <p>الحالة</p>
                            <select type="text" class="form-control" v-model="field.update_status">
                                <option :value="0" selected>غير مفعل</option>
                                <option :value="1">مفعل</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button @click="UpdateStatus()" type="button" class="btn btn-primary" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            no_active_marketer:0,
            active_marketer:0,
            infos:[],
            marketers:[],
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
            }
        };
    },
    methods:{
        FetchMarketers:function(){
            let self = this;
            axios.get('/api/marketers',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.marketers          = self.infos.data;
                self.no_active_marketer = data.no_active_marketer;
                self.active_marketer    = data.active_marketer;
            }).catch(function({response}){
                console.log(response);
            });
        },
        DeleteMarketer:function(id,name){
            if(confirm(`تأكيد حذف مسوق ${ name }`)){
                let self = this;
                axios.delete('/api/marketers/'+id).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.success  = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                    };
                    self.FetchMarketers();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        TruncateMarketers:function(){
            if(confirm(`تأكيد حذف كل التجار`)){
                let self = this;
                axios.delete('/api/marketers/delete-selected',{
                    params:{
                        type:'all'
                    }
                }).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.success  = data.result;
                    self.params = {
                        page:1
                    };
                    self.FetchMarketers();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        DeleteSelectedMarketers:function(){
            if(confirm(`تأكيد حذف المسوق المحدد`)){
                let self = this;
                axios.delete('/api/marketers/delete-selected',{
                    params:{
                        type:'selected',
                        marketers:self.selected
                    }
                }).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.success  = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                    };
                    self.FetchMarketers();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        ShowModelUpdateStatus:function(){
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
           this.showModel = false;
        },
        UpdateStatus:function(){
            let self = this;
            this.field.ids = this.selected;
            axios.put('/api/marketers/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchMarketers();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        }
    },
    created:function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        this.FetchMarketers();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {q:search};
                axios.get('/api/marketers/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = [];
                    self.marketers          = data.data_info;
                    self.no_active_marketer = data.no_active_marketer;
                    self.active_marketer    = data.active_marketer;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchMarketers();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.marketers.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.marketers.forEach(function(item){
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
