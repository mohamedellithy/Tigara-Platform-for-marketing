<template>
    <div class="container-body-schedule">
        <form method="post" @submit.prevent="CreateNewCampaigns()">
            <h3 class="title-schedule">
                <i class="far fa-calendar-plus"></i>
                تعديل حملة {{ campaign.name }}
            </h3>
            <div class="container-submit-btn-schedule">
                <button type="submit" class="btn btn-success">
                    <i class="far fa-calendar-check"></i>
                    تعديل الخملة و نشرها
                </button>
                <button type="button" @click="CreateNewDraftCampaigns" value="0" class="btn btn-danger">
                    <i class="fas fa-calendar-day"></i>
                    تعديل الحملة كمسودة
                </button>
            </div>
            <div class="row">
                <div v-if="Object.keys(this.errors).length !== 0" class="col-12 container-errors">
                    <div class="alert alert-danger">
                         <ul>
                            <li v-for="(error,index) in errors" :key="index"> {{ error[0] }}</li>
                         </ul>
                    </div>
                </div>
                <div class="col-lg-6 container-form-new-schedule">
                    <div class="form-group">
                        <label for="schedule-name">
                            <i class="fas fa-clipboard-list"></i>
                            اسم الحملة
                        </label>
                        <input id="schedule-name" class="form-control" type="text" v-model="campaign.name"/>
                    </div>
                    <div class="form-group">
                        <label for="schedule-name">
                            <i class="fas fa-clipboard-list"></i>
                            وصف الحملة
                        </label>
                        <textarea id="schedule-name" class="form-control" rows="10" cols="20" v-model="campaign.description"></textarea>
                    </div>
                </div>
                <div class="col-lg-6 container-form-new-schedule">
                    <div class="form-group">
                        <label for="schedule-name">
                            <i class="far fa-calendar-plus"></i>
                            المهمة التى تريد انشاء جدولة لها
                        </label>
                        <p class="schedule-event-name">
                            <i class="fas fa-project-diagram"></i>
                              {{ this.events[campaign.action] ? this.events[campaign.action] : this.events[0]  }}
                            <span @click="browseEvents = true" class="change-event">
                                <i class="fas fa-retweet"></i>
                                تغير المهمة
                            </span>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="schedule-name">
                            <i class="fas fa-retweet"></i>
                            تكرار الحملة المجدولة
                        </label>
                        <p class="schedule-event-name">
                            <i class="fas fa-project-diagram"></i>
                             {{ repeates[campaign.repeate] ? repeates[campaign.repeate] : repeates[0] }}
                            <span @click="browseTimes = true" class="change-event">
                                <i class="fas fa-retweet"></i>
                                تغير تكرار الحملة
                            </span>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="schedule-name">
                            <i class="fas fa-database"></i>
                            تحديد المنتجات
                        </label>
                        <p class="schedule-event-name">
                            <i class="fas fa-project-diagram"></i>
                            عدد المنتجات المحددة ( {{ this.campaign.products.length !== 0 ? this.campaign.products.length : 'بدون تحديد'  }} ) منتج
                            <span @click="browseProducts = true" class="change-event">
                                <i class="fas fa-retweet"></i>
                                تغير المنتجات
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </form>
        <events-model :show-events="browseEvents" :campaign="campaign"
         @updateFromEventCampaign="updateFromEventCampaign"
         @modelshow="updateshow"
         ></events-model>

        <times-model :show-times="browseTimes" :campaign="campaign"
         @updateFromTimesCampaign="updateFromTimesCampaign"
         @modelshow="updateshow"></times-model>

        <products-model :show-products="browseProducts" :campaign="campaign"
         @updateFromProductsCampaign="updateFromProductsCampaign"
         @modelshow="updateshow"></products-model>
    </div>
</template>
<script>
import EventsModel from './Models/Events.vue';
import TimesModel from './Models/Times.vue';
import ProductsModel from './Models/Products.vue';
export default {
    components: {
        EventsModel,
        TimesModel,
        ProductsModel
    },
    data(){
        return{
            schedule:{},
            campaign:{
                status:1,
                reapete_on:[],
                action:"0",
                end_type_cal:"0",
                unit_repeate:"0",
                repeate:"0",
                products:[]
            },
            default:{
                status:1,
                reapete_on:[],
                action:"0",
                end_type_cal:"0",
                unit_repeate:"0",
                repeate:"0",
                products:[]
            },
            events:{
                0 : 'نشر المنتجات',
                1 : 'الغاء نشر المنتجات',
                2 : 'تخفيضات على المنتجات',
                3 : 'تغير فى سعر المنتج',
                4 : 'اضافة الترميزات الخاصة بالمنتح',
                5 : 'حذف الترميزات الخاصة بالمنتج'
            },
            repeates:{
                0        : "بدون تكرار",
                daily    : "يوميا",
                weekly   : "اسبوعيا كل خميس",
                monthly  : "شهريا كل اول خميس",
                annually : "سنويا كل مطلع شهر يناير",
                weekends : "كل ايام العطلات من الجمعة حتى الاثنين",
                custom   : "تكرار مخصص",
            },
            browseEvents:false,
            browseTimes:false,
            browseProducts:false,
            errors:{},
        }
    },
    methods:{
        updateshow:function(status){
            this.browseEvents    = status;
            this.browseTimes     = status;
            this.browseProducts  = status;
        },
        CreateNewCampaigns:function(status = 1){
            let self = this;
            this.campaign.status = status;
            console.log(this.campaign.status);
            axios.put('/api/campaigns/'+this.$route.params.id,this.campaign).then(function({data}) {
                console.log(data);
                self.errors = {};
                //self.campaign = data.campaigns;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            });
        },
        CreateNewDraftCampaigns:function(){
            console.log(this.campaign);
            this.CreateNewCampaigns(0);
        },
        updateFromEventCampaign:function(value){
           this.campaign = value;
           console.log(value);
           console.log(this.campaign);
        },
        updateFromTimesCampaign:function(value){
           this.campaign = value;
           console.log(value);
           console.log(this.campaign);
        },
        updateFromProductsCampaign:function(value){
           this.campaign = value;
           console.log(value);
           console.log(this.campaign);
        }
    },
    created(){
        let self = this;
        axios.get('/api/campaigns/'+this.$route.params.id).then(function({data}) {
            console.log(data);
            self.campaign = data.campaign;
        }).catch(function({response}) {
            console.log(response);
            self.errors = response.data;
        });
    }
}
</script>

<style scoped>
.container-body-schedule{
    padding: 4%;
}
.title-schedule{
    line-height:2.5em;
    color: #795548;
}
.container-form-new-schedule{
    padding: 1% 3%;
}
.container-form-new-schedule .form-group label
{
    line-height: 3em;
    font-size: 17px;
}
.container-submit-btn-schedule{
    text-align: left;
}
.schedule-event-name{
    padding: 10px 23px;
    background-color: #cff0d0;
    font-weight: bold;
    position: relative;
    border: 1px solid #eee;
}
.change-event{
    position: absolute;
    left: 0;
    top: 0;
    padding: 10px;
    background-color: white;
    box-shadow: 0px 9px 15px 8px #d0d0d0;
    cursor: pointer;
}
.container-errors{
    padding: 20px 30px 0px 26px;
}
.container-errors .alert
{
    border-radius: 0px;
    background-color: #ffeced;
    box-shadow: 0px 0px 0px 0px #eee;
    border: none;
}
</style>
