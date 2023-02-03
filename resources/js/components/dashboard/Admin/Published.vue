<template>
    <!-- <div class="col-8 show-alert-messaage">
         <img class="schedule-img" :src="require('../../../img/image_processing20200627-19092-c2s8xo.gif')">
         <p class="description-schedule-empty">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus tenetur nam adipisci deserunt consequuntur eius laboriosam, eaque eveniet assumenda esse. Cumque architecto culpa cupiditate dolorem ipsa, quae neque repudiandae impedit.</p>
         <div class="frame-btn-schedule">
              <router-link tag="button" class="btn btn-success" :to="{name:'add-schedules'}">اضافة حملة جديدة</router-link>
         </div>
    </div> -->
    <div class="col-12">
        <div class="row container-top-content">
            <div class="col-lg-2">
                <router-link tag="button" class="btn btn-success" :to="{name:'add-schedules'}">اضافة حملة جديدة</router-link>
            </div>
        </div>
        <div class="row">
            <div class="container-card col-md-4">
                <div class="card">
                    <div class="status">
                        <span class="badge text-bg-success">
                            <i class="fas fa-eye"></i>
                            منشورة
                        </span>
                        <span class="badge text-bg-danger">منتهية</span>
                    </div>
                    <div class="header-top-card">
                        <h6>الحملة المجدولة الاولى لنشر المنتجات</h6>
                    </div>
                    <div class="body-card">
                        <div class="container-description">
                            <p class="description">
                                هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.
                            </p>
                            <hr/>
                        </div>
                        <div class="container-dates">
                            <ul class="props-card">
                                <li>
                                    <label for="">تاريخ انشاء الحملة</label> <br/>
                                    <strong>Sat 12 , 2022 10:22:12 pm</strong><br/>
                                </li>
                                <li>
                                    <label for="">مهمة التى تقوم بها الحملة</label> <br/>
                                    <strong class=""> نشر المنتجات </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="footer-card">
                        <button type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                            تعديل الحملة
                        </button>
                        <button type="button" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                            تقاصيل الحملة
                        </button>
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-ban"></i>
                            تشغيل الحملة
                        </button>
                    </div>
                </div>
            </div>

            <div class="container-card col-md-4">
                <div class="card">
                    <div class="status">
                        <span class="badge text-bg-success">منشورة</span>
                        <span class="badge text-bg-primary">تعمل</span>
                    </div>
                    <div class="header-top-card">
                        <h6>الحملة المجدولة الاولى لنشر المنتجات</h6>
                    </div>
                    <div class="body-card">
                        <div class="container-description">
                            <p class="description">
                                هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.
                            </p>
                            <hr/>
                        </div>
                        <div class="container-dates">
                            <ul class="props-card">
                                <li>
                                    <label for="">تاريخ انشاء الحملة</label> <br/>
                                    <strong>Sat 12 , 2022 10:22:12 pm</strong><br/>
                                </li>
                                <li>
                                    <label for="">مهمة التى تقوم بها الحملة</label> <br/>
                                    <strong class=""> نشر المنتجات </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="footer-card">
                        <button type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                            تعديل الحملة
                        </button>
                        <button type="button" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                            تقاصيل الحملة
                        </button>
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-ban"></i>
                            تشغيل الحملة
                        </button>
                    </div>
                </div>
            </div>

            <div class="container-card col-md-4">
                <div class="card">
                    <div class="status">
                        <span class="badge text-bg-success">منشورة</span>
                        <span class="badge text-bg-danger">موقوفة</span>
                    </div>
                    <div class="header-top-card">
                        <h6>الحملة المجدولة الاولى لمسودة المنتجات</h6>
                    </div>
                    <div class="body-card">
                        <div class="container-description">
                            <p class="description">
                                هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.
                            </p>
                            <hr/>
                        </div>
                        <div class="container-dates">
                            <ul class="props-card">
                                <li>
                                    <label for="">تاريخ انشاء الحملة</label> <br/>
                                    <strong>Sat 12 , 2022 10:22:12 pm</strong><br/>
                                </li>
                                <li>
                                    <label for="">مهمة التى تقوم بها الحملة</label> <br/>
                                    <strong class="">الغاء نشر المنتجات  </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="footer-card">
                        <button type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                            تعديل الحملة
                        </button>
                        <button type="button" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                            تقاصيل الحملة
                        </button>
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-ban"></i>
                            تشغيل الحملة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.row{
    margin: 0px;
}
.show-alert-messaage{
    height:auto;
    /*background-color: antiquewhite;*/
    padding:20px;
    text-align:center;
    margin:auto;
    margin-top:5%;
}

.schedule-img{
    width: 31%;
    height: 220px;
    border-radius: 60%;
}

p.description-schedule-empty{
    padding: 6% 15%;
}
.container-card{
    padding: 20px;
}
.card{
    padding: 25px;
    border: 1px solid #e0dfdf;
    border-radius: 1px;
    box-shadow: 0px 5px 10px 8px #eee;
}
.header-top-card h6{
    line-height: 2em;
    font-size: 19px;
    padding: 14px 0px;
}
.props-card{
    width: 100%;
    padding: 0px 20px;
}
.props-card li{
        padding: 12px 13px;
}
.badge{
    font-size: 13px !important;
}
.footer-card .btn{
    font-size: 11px;
}
.container-top-content{
    padding: 16px 9px 0px;
}
</style>
