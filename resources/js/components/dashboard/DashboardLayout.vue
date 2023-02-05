<template>
    <div class="section-row-layouts">
        <div :class="[ (this.toggleSide ? 'active': 'no-active') + ' sidemenu' ]">
            <div class="header-shop">
                <label class="header-shop-logo"></label>
                <label class="header-shop-name">Logo</label>
            </div>
            <!-- mobile Profile dropdown menu -->
            <ul class="menu-list">
                <li class="nav-item list-items-menu dropdown mobile-profile-dropdown" @click="toggleDropdown">
                    <img :src="this.iconsProfile" />
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" >
                        {{ $filters.handleEmail($auth.user.email) }}
                    </a>
                    <div v-if="toggle" class="dropdown-menus-vue">
                        <router-link tag="a" class="dropdown-item" :to="{name:'login'}">
                            <i class="fas fa-users-cog"></i>
                            اعدادات الحساب
                        </router-link>
                        <a @click="LogOut" class="dropdown-item" href="#">
                            <i class="fas fa-sign-out-alt"></i>
                            تسجيل الحروج
                        </a>
                    </div>
                </li>

                <admin-sidebar v-if="this.$auth.user.account_type == 0"></admin-sidebar>
                <merchant-sidebar v-if="this.$auth.user.account_type == 1"></merchant-sidebar>
                <delivery-sidebar v-if="this.$auth.user.account_type == 2"></delivery-sidebar>
                <marketer-sidebar v-if="this.$auth.user.account_type == 3"></marketer-sidebar>
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
                            <label class="header-shop-logo"></label>
                            <label class="header-logo">Logo</label>
                        </li>
                        <!-- end logo -->
                        <!-- search bar -->
                        <li class="nav-item search-container">
                            <input placeholder="Search..." name="" class="form-control search-navbar"/>
                        </li>
                        <!-- end search bar -->
                        <!-- Profile dropdown menu -->
                        <li class="nav-item dropdown profile-dropdown" @click="toggleDropdown">
                            <img :src="this.iconsProfile" />
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" >
                                {{ $filters.handleEmail($auth.user.email) }}
                            </a>
                            <div v-if="toggle" class="dropdown-menus-vue">
                                <router-link tag="a" class="dropdown-item" :to="{name:'login'}">
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
            <!-- <div class="container">
                <div class="row"> -->
                    <div class="container-content">
                        <div class="topbar-permalink">
                            <span>الرئيسية / </span>
                            <router-link tag="span" :to="{name:'login'}" style="text-decoration: none;">
                                {{ this.$route.meta.ar_name }}
                            </router-link>
                        </div>
                        <router-view :key="$route.fullPath"></router-view>
                    </div>
                <!-- </div>
            </div> -->
        </div>
    </div>
</template>
<script>
import svgrepoCom from '@/img/menu-2-svgrepo-com.svg';
import iconsProfile from '@/img/Circle-icons-profile.svg.png';
import AdminSidebar from './SideBars/AdminSidebar.vue';
import MerchantSidebar from './SideBars/MerchantSidebar.vue';
import DeliverySidebar from './SideBars/DeliverySidebar.vue';
import MarketerSidebar from './SideBars/MarketerSidebar.vue';
export default {
    components: { AdminSidebar,MerchantSidebar,DeliverySidebar,MarketerSidebar},
    data(){
        return {
           toggle:false,
           toggleSide:false,
           svgrepoCom,
           iconsProfile,
           expanded:[],
        }
    },
    methods: {
        toggleDropdown:function(){
            this.toggle        = !this.toggle;
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
        }
    },
    created(){
        console.log(this.$auth.user);
    }
}
</script>
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
    margin-top: 21px;
    margin-left:20px;
    width: auto;
    height: 36px;
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
    width: 905px;
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
        width:100%;
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
        margin-top: 8px;
        margin-left: 5px;
        width: 23px;
        height: 22px;
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
        width: 60%;
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
    }
    .list-items-menu a.item-menu{
        padding: 15px 10px;
    }
    .mobile-profile-dropdown{
        padding: 15px 10px 15px 0px;
        border-bottom: 1px solid #e6e6e6;
        border-top: 1px solid #e6e6e6;
        background-color: #e6e6e6;
        border-radius: 0px;
    }
    .mobile-profile-dropdown img{
        width: 20px;
    }
    .mobile-profile-dropdown a.dropdown-toggle{
        display: inline-block;
    }
}
</style>
