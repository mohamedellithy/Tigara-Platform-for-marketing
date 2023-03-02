<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="top-cart-complete">
                    <li class="active">
                        <span class="container-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                        <label>السلة</label>
                    </li>
                    <li>
                        <span class="container-icon">
                            <i class="fas fa-id-card-alt"></i>
                        </span>
                        <label>بيانات الزبون</label>
                    </li>
                    <li>
                        <span class="container-icon">
                            <i class="fas fa-pallet"></i>
                        </span>
                        <label>تفاصيل الطلب</label>
                    </li>
                </ul>
                <div class="row">
                    <div class="container-mini-cart">
                        <h4>تفاصيل السلة</h4>
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
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-details">
                <div class="order-details-info">
                    <table class="table">
                        <tr>
                            <th>كمية الطلبية</th>
                            <td>
                                <strong>1220 USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>عدد المنتجات</th>
                            <td>
                                <strong>122</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>الخصم على الطلبية</th>
                            <td>
                                <strong>1220 USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>اجمالى الطلبية</th>
                            <td>
                                <strong>109374 USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>الربح من الطلبية</th>
                            <td>
                                <strong>122 USD</strong>
                            </td>
                        </tr>
                       
                        <tr>
                            <td colspan="2" class="text-center">
                                <button class="btn completeShoping">
                                    <i class="fas fa-shopping-cart"></i>
                                    متابعة التسوق
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return {
            message: 'Hello World',
            cart_items:[]
        }
    },
    methods : { 
        FetchCartItems:async function(){
            let self = this;
            await axios.get('/api/marketer-carts').then(function({data}){
                console.log(data);
                self.cart_items = data.cart_items;
            }).catch(function({response}){
                console.log(response);
            });
        },
    },
    created(){
        this.FetchCartItems();
    }
}
</script>
<style scoped>
.order-details{
    padding:20px;
}
.order-details-info{
    background-color: #75e3b087;
    box-shadow: 3px 13px 13px 14px #eee;
}
.order-details-info tr:not(tr:last-child)
{
    border-bottom: 3px dashed #5c5b5b47;
}
.order-details-info tr th,
.order-details-info tr td
{
    padding: 30px 20px;
}
.order-details-info tr th{
    text-align: right;
}
.order-details-info tr td{
    text-align: left;
}
.completeShoping{
    background-color: #171717;
    border-radius: 29px;
    padding: 10px 20px;
    color: white;
}
.top-cart-complete{
    list-style: none;
    text-align: center;
}
.top-cart-complete li
{
    display: inline-block;
    padding: 22px 40px;
}
.top-cart-complete li span
{    
    display: block;
    background-color: white;
    padding: 19px;
    border-radius: 74px;
    border: 6px solid #b5beba;
}
.top-cart-complete li span i
{
    font-size: 40px;
    color: #c4c4c4;
}
.top-cart-complete li label
{
    line-height: 2.5em;
}
.top-cart-complete li.active span{
    border:6px solid #087c46c9;
}
.top-cart-complete li.active span i{
    color: #ffc30d;
}

.container-mini-cart{
    /* min-height: 200px;
    max-height: 500px; */
    background-color: white;
    padding: 10px;
    z-index: 100000;
}
.container-mini-cart
{
    padding: 10px 7px;
}
.container-mini-cart .content-mini-cart{
    /* max-height: 360px;
    overflow-y: auto; */
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
</style>