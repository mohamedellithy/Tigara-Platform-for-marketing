<template>
    <div class="container-fluid">
        <section class="row" :style="`backgroundImage: url(${require('../../img/pattern.png')});min-height:755px;background-color: rgb(28 65 158);`">
            <div class="col-lg-7 text-center container-alert-integrated">
                <h2 class="title-login" style="">تم تفعيل التطبيق بنجاح على منصة زد</h2>
                <img class="img-zid" :src="require('../../img/zid.png')" />
                <div class="description-login">
                    كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص
                </div>
                <br/>
                <div class="alert alert-warning"> يمكنك ادارة تطبيقك من خلال لوحة تحكم متكاملة</div>
                <router-link tag="a" class="btn btn-success" :to="{name:'show-schedules'}" exact>
                   ابدأ فى ادارة تطبيقك الان
                </router-link>
            </div>
        </section>
    </div>
</template>
<style scoped>
.container-alert-integrated{
    margin: auto;
    background: white;
    padding: 6%;
    border-radius: 10px;
}
.container-alert-integrated .title-login
{
    line-height: 2em;
}
.container-alert-integrated .img-zid
{
   width:20%;
}
</style>