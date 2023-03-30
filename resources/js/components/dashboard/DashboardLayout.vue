<template>
    <div class="section-row-layouts">
        <div :class="[ (this.toggleSide ? 'active': 'no-active') + ' sidemenu' ]">
            <div class="header-shop" style="text-align: center;">
                <!-- <label class="header-shop-logo"></label> -->
                <router-link v-if="this.$auth.user.account_type == 0" :to="{path:'/dashboard/dashboard-reports'}">
                    <img class="header-shop-name" :src="this.tigaraIcon" />
                </router-link>
                <router-link v-if="this.$auth.user.account_type == 1" :to="{path:'/merchant/dashboard-reports'}">
                    <img class="header-shop-name" :src="this.tigaraIcon" />
                </router-link>
                <router-link v-if="this.$auth.user.account_type == 2" :to="{path:'/delivery/dashboard-reports'}">
                    <img class="header-shop-name" :src="this.tigaraIcon" />
                </router-link>
                <router-link v-if="this.$auth.user.account_type == 3" :to="{path:'/marketer/dashboard-reports'}">
                    <img class="header-shop-name" :src="this.tigaraIcon" />
                </router-link>
                <!-- <label class="header-shop-name">
                </label> -->
            </div>
            <!-- mobile Profile dropdown menu -->
            <ul class="menu-list">
                <li class="nav-item list-items-menu dropdown mobile-profile-dropdown" @click="toggleDropdown">
                    <img :src="this.iconsProfile" />
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" >
                        {{ $filters.handleEmail($auth.user.email) }}
                    </a>
                    <div v-if="toggle" class="dropdown-menus-vue">
                        <router-link tag="a" class="dropdown-item" :to="{path:'/dashboard/setting-account'}">
                            <i class="fas fa-users-cog"></i>
                            اعدادات الحساب
                        </router-link>
                        <a @click="LogOut" class="dropdown-item" href="#">
                            <i class="fas fa-sign-out-alt"></i>
                            تسجيل الحروج
                        </a>
                    </div>
                </li>
                <admin-sidebar     v-if="this.$auth.user.account_type == 0"></admin-sidebar>
                <merchant-sidebar  v-if="this.$auth.user.account_type == 1"></merchant-sidebar>
                <delivery-sidebar  v-if="this.$auth.user.account_type == 2"></delivery-sidebar>
                <marketer-sidebar  v-if="this.$auth.user.account_type == 3"></marketer-sidebar>
                <!-- :key="$route.path" -->
                <!-- end menu items -->
            </ul>
        </div>
        <div :class="[ (this.toggleSide ? 'active': 'no-active') + ' container-dashboard' ]">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#" @click="ToggleSidebar">
                    <img :src="this.svgrepoCom"/>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <!-- logo -->
                        <li class="nav-item mobile-header-logo">
                            <!-- <label class="header-shop-logo"> -->
                                <img class="header-shop-logo" src="@/img/tigara-trans.png"/>
                            <!-- </label> -->
                        </li>
                        <!-- end logo -->
                        <!-- search bar -->
                        <li class="nav-item search-container">
                            <input placeholder="Search..." name="" class="form-control search-navbar"/>
                        </li>
                        <!-- end search bar -->
                        <li :key="$route.fullPath" v-if="this.$auth.user.account_type == '3'" class="nav-item top-cart-icon" @click="ToggleMiniCart">
                            <a class="nav-link">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="show-cart-notification">{{ this.total_cart_items || 0  }}</span>
                            </a>
                        </li>
                        <!-- Profile dropdown menu -->
                        <li class="nav-item dropdown profile-dropdown" @click="toggleDropdown">
                            <img :src="this.iconsProfile" />
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" >
                                {{ $filters.handleEmail($auth.user.email) }}
                            </a>
                            <div v-if="toggle" class="dropdown-menus-vue">
                                <router-link tag="a" class="dropdown-item" :to="{path:'/dashboard/setting-account'}">
                                    <i class="fas fa-users-cog"></i>
                                    اعدادات الحساب
                                </router-link>
                                <a @click="LogOut" class="dropdown-item" href="#">
                                    <i class="fas fa-sign-out-alt"></i>
                                    تسجيل الحروج
                                </a>
                            </div>
                        </li>
                        <!-- end Profile dropdown menu -->
                        <!-- toggle btn -->
                        <li class="nav-item mobile-toggleIcon"  @click="ToggleSidebar">
                            <img :src="this.svgrepoCom"/>
                        </li>
                        <!-- end toggle btn -->
                    </ul>
                </div>
            </nav>

            <div class="container-mini-cart" v-if="toggleMiniCart == true" :key="$route.fullPath">
                <div class="content-mini-cart">
                    <table class="table mini-cart">
                        <tr>
                            <th>المنتج</th>
                            <th>كمية المنتج</th>
                            <th>سعر المنتج</th>
                            <th></th>
                        </tr>
                        <tr v-for="(item,key) in cart_items" :key="key">
                            <td>
                                <img :src="item.product.thumbnail_item.image_url"  class="mini-cart-product-image"/>
                                <label class="product-name">
                                    {{ item.product.name }}
                                </label>
                            </td>
                            <td>
                                <span class="fas fa-plus quantity-varite" @click="PlusQuantity(item)"></span>
                                <label class="quantity-mini-cart">{{  item.quantity || 1  }}</label>
                                <span class="fas fa-minus quantity-varite" @click="MinusQuantity(item)"></span>
                            </td>
                            <td>{{ item.price }} USD</td>
                            <td>
                                <i class="fas fa-times-circle" @click="deleteItemFromCart(item)"></i>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="text-center" style="padding:10px">
                    <router-link class="btn go_to_checkout" :to="{name:'marketer-carts'}">
                        <i class="fas fa-dolly-flatbed"></i>
                        استكمال الطلب
                    </router-link>
                </div>
            </div>
            <div class="container-content">
                <div class="topbar-permalink">
                    <span>الرئيسية / </span>
                    <router-link tag="span" :to="{name:'login'}" style="text-decoration: none;">
                        {{ this.$route.meta.ar_name }}
                    </router-link>
                </div>
                <router-view :key="$route.fullPath" @updateQuantity="updateQuantity"></router-view>
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
import svgrepoCom from '@/img/menu-2-svgrepo-com.svg';
import iconsProfile from '@/img/Circle-icons-profile.svg.png';
import AdminSidebar from './SideBars/AdminSidebar.vue';
import MerchantSidebar from './SideBars/MerchantSidebar.vue';
import DeliverySidebar from './SideBars/DeliverySidebar.vue';
import MarketerSidebar from './SideBars/MarketerSidebar.vue';
import tigaraIcon from '@/img/tigara-trans.png';
export default {
    components: { AdminSidebar,MerchantSidebar,DeliverySidebar,MarketerSidebar,tigaraIcon},
    data(){
        return {
           toggle:false,
           toggleSide:false,
           toggleMiniCart:false,
           svgrepoCom,
           iconsProfile,
           tigaraIcon,
           expanded:[],
           total_cart_items:0,
           cart_items:[],
           showsuccess:false,
           showerrors:false,
           success_message:'تم انشاء التاجر بنجاح',
           error_message:'حدث خطأ اثناء انشاء التاجر',
           loading:true
        }
    },
    methods: {
        toggleDropdown:function(){
            this.toggle = !this.toggle;
            this.toggleSide = true;
        },
        LogOut:async function(){
            let self = this;
            await axios.post('/api/logout').then(function({data}){
               console.log(data);
               self.$auth.logoutAuthToken();
               self.$router.push({name: 'login'})
            }).catch(function({response}){
                console.log(response);
            });
        },
        ToggleSidebar:function(){
            this.toggleSide = !this.toggleSide;
        },
        ToggleMiniCart:function(){
            this.toggleMiniCart = !this.toggleMiniCart;
        },
        toggleListMenuSidebar:function(item){
            if(this.expanded.indexOf(item) !== -1){
                this.expanded.pop(item);
                this.expanded = [];
            }
            else{
                this.expanded = [];
                this.expanded.push(item);
            }
            console.log(this.expanded);
        },
        updateQuantity:function(qunatity,cart_items){
            this.total_cart_items = qunatity;
            this.cart_items = cart_items;
            console.log('hi update here');
        },
        async FetchCartItems(){
            let self = this;
            await axios.get('/api/marketer-carts').then(function({data}){
                console.log(data);
                self.cart_items = data.cart_items;
            }).catch(function({response}){
                console.log(response);
            });
        },
        PlusQuantity:async function(item){
            let self = this;
            let field = {};
            field.type = "plus";
            await axios.put('/api/marketer-carts/'+item.id,field).then(function({data}){
                if(data.status){
                    self.showerrors = true;
                    self.error_message = data.status;
                }
                self.cart_items = data.cart_items;
                self.total_cart_items = data.total_quantity;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        },
        MinusQuantity:async function(item){
            let self = this;
            let field = {};
            if(item.quantity == 1){
                return;
            }
            field.type = "minus";
            await axios.put('/api/marketer-carts/'+item.id,field).then(function({data}){
                self.cart_items = data.cart_items;
                self.total_cart_items = data.total_quantity;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        },
        deleteItemFromCart:async function(item){
            let self = this;
            await axios.delete('/api/marketer-carts/'+item.id).then(function({data}){
                self.cart_items = data.cart_items;
                self.total_cart_items = data.total_quantity;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    async created(){
        if(this.$auth.user.account_type == '3'){
            this.total_cart_items = this.$auth.user.total_cart_items;
            await this.FetchCartItems();
        }
        console.log('hiddddddddddd');
    },
    watch:{
        "$route":function(){
            this.toggleMiniCart = false;
            if(this.toggle != true){
                this.toggleSide = false;
            }
        }
    }
}
</script>
<style>
.reports-tabs li a{
    text-decoration: none;
}
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: hsl(0deg 0% 56% / 74%);
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: hsl(0deg 3% 20% / 74%);
    border-radius: 10px;
}
.sidemenu .menu-list{
    height: 95%;
    overflow-y: auto;
}
/* .text-nowrap {
    white-space: normal !important;
} */

</style>
<style scoped>

.section-row-layouts{
    position: relative;
}
.sidemenu{
    position: fixed;
    top: 0px;
    right: 0px;
    bottom: 0px;
    width: 18%;
    background: var(--bg) 0% 0% no-repeat padding-box;
    background: #F2F2F2 0% 0% no-repeat padding-box;
}
.container-dashboard{
    /* position: absolute;
    top: 0px;
    left: 12px;
    bottom: 0px;
    width: 82%;
    height: 1184px;
    padding: 0px; */
    position: absolute;
    top: 0px;
    right: 18%;
    bottom: 0px;
    padding: 0px;
    width: 82%;
}
.header-shop-logo{
    margin-top: 24px;
    margin-left: 16px;
    width: 30px;
    height: 30px;
    /* UI Properties */
    background: #FFBC5D 0% 0% no-repeat padding-box;
    opacity: 1;
}
.header-shop-name
{
    /* margin-top: 21px; */
    margin-left:20px;
    width: auto;
    height: 80px;
    font: var(--unnamed-font-style-normal) normal var(--unnamed-font-weight-600) 26px/39px var(--unnamed-font-family-poppins);
    letter-spacing: var(--unnamed-character-spacing-0);
    color: var(--heading);
    text-align: left;
    font: normal normal 600 26px/39px 'Tajawal', sans-serif;
    letter-spacing: 0px;
    color: #3B3B3B;
    opacity: 1;
}
.menu-list{
    padding: 20px;
}
.list-items-menu{
    opacity: 1;
    list-style: none;
    overflow: hidden;
}
.list-items-menu a.item-menu{
    cursor: pointer;
    padding: 13px 18px;
    /* UI Properties */
    border-radius: 8px;
}
.list-items-menu a.active{
    background: var(--surface) 0% 0% no-repeat padding-box;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    box-shadow: -2px 2px 1px #00000008;
    box-shadow: -2px 2px 1px #00000008;
}
.item-menu{
    color:rgb(22, 21, 21);
    font-size: 16px;
    text-decoration: none;
    cursor: pointer !important;
    width: 100%;
    display: block;
    position: relative;
}
.item-menu .chevron{
    position: absolute;
    left: 3%;
    top: 36%;
}
.item-menu label{
    cursor: pointer !important;
    padding:0px 10px;
    font-size: 17px;
}
.item-menu i
{
    width: 25px;
    height: 26px;
    /* UI Properties */
    opacity: 1;
    color: #666666;
}
.navbar-expand-lg .navbar-collapse {
    display: block !important;
    flex-basis: auto;
}
.navbar.navbar-expand-lg.navbar-light.bg-light{
    background-color: #f2f2f2 !important;
    padding: 15px 0px;
    position: fixed;
    left: 0;
    right: 17%;
    z-index: 10000;
}
.container-content{
    margin-top: 4%;
    padding: 20px 0px;
}
.search-navbar,
.search-navbar:hover,
.search-navbar:focus{
    top: 16px;
    left: 334px;
    width: 850px;
    height: 40px;
    background: var(--grey-300) 0% 0% no-repeat padding-box;
    background: #E8E8E8 0% 0% no-repeat padding-box;
    border-radius: 8px;
    opacity: 1;
    border: 2px solid #e7e6e6 !important;
    padding: 15px;
}
.topbar-permalink{
    padding: 19px 31px;
    /*padding: 10px 10px;*/
    background-color: #edecea;
    background-color: #ffecb34d;
}
.navbar-nav .nav-item.dropdown{
    background-color: #fafafa;
    padding: 0px 20px;
    direction: rtl;
    margin: 0px 15px;
}
.navbar-expand-lg .navbar-nav{
    float: left;
}
.navbar-expand-lg .navbar-nav .nav-item img{
    width: 30px;
    display: inline-block;
}
.navbar-expand-lg .navbar-nav .nav-link{
    display: inline-block;
}
.dropdown-menus-vue{
    position: absolute;
    background-color: white;
    padding:0px;
    left: 0px;
    right: 0px;
    box-shadow: 12px 23px 21px 0px #eee;
}
.dropdown-menus-vue .dropdown-item{
    border-bottom: 1px solid #eee;
    padding: 10px 15px;
}

.active.sidemenu .list-items-menu label ,
.active.sidemenu .header-shop .header-shop-name{
   display: none;
}
.active.sidemenu .list-items-menu a.item-menu{
    text-align: center;
}

.nav-link.dropdown-toggle{
    direction: ltr;
}
.list-items-menu .child-list-items-menu{
    background-color: white;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-left: 2px;
}
.list-items-menu .child-list-items-menu .li-child-list-items-menu
{
    list-style: none;
    padding: 10px;
    border-bottom: 1px solid #eee;
}
.list-items-menu .child-list-items-menu .li-child-list-items-menu a.a-child-list-item-menu
{
    text-decoration: none;
    color: #2e2c2c;
    font-size: 13px;
}
.list-items-menu .child-list-items-menu .li-child-list-items-menu a.a-child-list-item-menu label{
    padding: 0px 10px;
    font-size: 16px;
}
.child-list-items-menu{
    /* animation: notactiveListMenu 1s ease-in-out .3s forwards; */
    height:auto !important;
}
.child-list-items-menu.active{
     /* animation: activeListMenu 1s ease-in-out .3s forwards; */
    height:0px !important;
    overflow: hidden;
}
.nav-item.top-cart-icon{
    font-size: 22px;
    padding: 0px 16px;
    color: #1b965d;
    position: relative;
    cursor: pointer;
}
.nav-item.top-cart-icon .show-cart-notification{
    position: absolute;
    right: 6px;
    top: 0px;
    background: #da1326;
    min-width: 23px;
    text-align: center;
    border-radius: 26px;
    font-size: 14px;
    color: white;
    border: 1px solid #da1326;
    cursor: pointer;
}
.container-mini-cart{
    position: fixed;
    top: 10%;
    left: 8%;
    right: auto;
    min-height: 200px;
    max-height: 500px;
    width: 40%;
    background-color: white;
    border: 2px solid #eee;
    border-radius: 19px;
    padding: 10px;
    box-shadow: 0px 6px 18px 10px #a8a8a857;
    z-index: 100000;


}
.container-mini-cart .content-mini-cart{
    max-height: 360px;
    overflow-y: auto;
}
.container-mini-cart table.mini-cart tr{
    border-bottom: 2px solid #eee;;
}
.container-mini-cart table.mini-cart tr:first-child
{
    position: sticky;
    top: 0px;
    background-color: white;
}
.container-mini-cart table.mini-cart tr th{
    padding: 10px;
    text-align: right;
}
.container-mini-cart table.mini-cart tr th:first-child{
    width: 45%;
}
.container-mini-cart table.mini-cart tr td{
    padding: 10px;
    text-align: right;
    width: 35%;
}
.container-mini-cart table.mini-cart tr td i.fa-times-circle{
    color: red;
}
.go_to_checkout{
    background-color: #1b965d;
    color: white;
    margin: auto;
    border-radius: 27px;

}
.container-mini-cart table.mini-cart tr td img.mini-cart-product-image{
    width: 25%;

}
.quantity-mini-cart{
    background: #eee;
    text-align: center;
    font-weight: bold;
    padding: 4px 26px;
}
.quantity-varite{
    padding: 1px 6px;
    font-size: 13px;
    cursor: pointer;
}
.container-mini-cart table.mini-cart tr td .product-name{
    font-weight: 500;
    padding: 6px;
    font-size: 13px;
}
@media(min-width:1000px){
    .active.sidemenu {
        animation: activeSubmenu .2s ease-in-out 0s forwards;
    }
    @keyframes activeSubmenu{
        to{
            width: 8%;
        }
    }

    .no-active.sidemenu{
        animation: noactiveSubmenu .4s inline 0s forwards;
    }
    @keyframes noactiveSubmenu{
        to{
        width: 18%;
        }
    }

    .active.container-dashboard {
        animation: activeContainerDashboard .2s ease-in-out 0s forwards;
    }
    @keyframes activeContainerDashboard{
        to{
            width: 92%;
            right: 8%;
        }
    }
    .active.container-dashboard .navbar.navbar-expand-lg.navbar-light.bg-light{
        right: 8%;
    }
    .mobile-header-logo ,
    .mobile-toggleIcon{
        display: none;
    }
    .mobile-profile-dropdown{
        display: none;
    }
}
@media(max-width:1000px){
    .sidemenu{
        left: 200%;
        right: auto;
    }
    .navbar.navbar-expand-lg.navbar-light.bg-light{
        right:0%;
    }
    .container-dashboard{
        right:0%;
        width:95%;
    }
    .navbar-nav{
        flex-direction: row;
        padding: 5px;
    }
    .profile-dropdown{
        display: none;
    }
    .mobile-header-logo .header-logo{
        font-size: 1.3pc;
    }
    .mobile-header-logo .header-shop-logo{
        margin-top: 5px;
        margin-left: 5px;
        width: 70px !important;
        height: 40px;
        background-color:transparent;
    }
    .navbar-brand{
        display: none;
    }
    .mobile-toggleIcon{
        padding: 2px 14px;
    }
    .mobile-toggleIcon img{
        width: 23px !important;
    }
    .container-content{
        margin-top: 15%;
    }
    .mobile-header-logo{
        width:30%;
    }
    .search-container{
       width: 60%;
       padding: 0px 13px;
    }
    .search-container .search-navbar
    {
        width: 100%;
    }

    .sidemenu{
        width: 80%;
    }
    .item-menu{
        font-size: 14px;
    }
    .sidemenu .list-items-menu a.item-menu{
       text-align: right !important;
    }
    .active.sidemenu {
        animation: activeSubmenu .2s ease-in-out 0s forwards;
        z-index: 1000000;
        box-shadow: 0px 4px 14px 9px #74747438;
    }
    @keyframes activeSubmenu{
        to{
            left:40%;
            right: 0%;
        }
    }
    .sidemenu .list-items-menu label ,
    .sidemenu .header-shop .header-shop-name{
        display: inline-block !important;
        text-align:right !important;
        height: 50px;
    }
    .list-items-menu a.item-menu{
        padding: 15px 10px;
    }
    .mobile-profile-dropdown{
        padding: 16px 13px 19px 12px;
        border-bottom: 1px solid #e6e6e6;
        border-top: 1px solid #e6e6e6;
        background-color: #e6e6e6;
        border-radius: 0px;
        margin-bottom: 14px;
        background-color: #cff0d0;
        color: black;
    }
    .mobile-profile-dropdown .dropdown-menus-vue{
        color: black;
        box-shadow: 0px 0px 0px 0px;
        margin-top: 13px;
    }
    .mobile-profile-dropdown img{
        width: 20px;
        margin: 0px 12px;
    }
    .mobile-profile-dropdown a.dropdown-toggle{
        display: inline-block;
    }
    .dropdown-menus-vue {
        position: relative;
    }
    .container-body-merchant {
        padding: 12% !important;
    }

    .container-mini-cart{
        width: 100%;
        left: 0%;
    }
    .container-mini-cart table.mini-cart tr th:first-child{
        width: 25%;
        font-size: 10px;
    }
    .container-mini-cart table.mini-cart tr th{
        font-size: 12px;
    }
    .quantity-varite{
        font-size: 9px;
    }
    .quantity-mini-cart{
        padding: 4px 15px;
    }
    .container-mini-cart table.mini-cart tr td{
        font-size: 12px;
    }
    .container-mini-cart table.mini-cart tr td img.mini-cart-product-image{
        width: 60%;
    }
    .go_to_checkout{
        font-size: 12px;
    }
    .nav-item.top-cart-icon{
        font-size: 15px;
    }
    .nav-item.top-cart-icon .show-cart-notification{
        min-width: 15px;
        font-size: 9px;
    }
}
</style>
