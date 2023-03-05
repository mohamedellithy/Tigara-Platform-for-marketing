import { createRouter, createWebHistory } from 'vue-router'
import Auth from './auth.js';

/**
 * @admin area
 * all components admin
 */

import MasterLayout from './components/MasterLayout.vue';
import LoginForm from './components/auth/Login.vue';
import RegisterForm from './components/auth/Register.vue';
import Dashboard from './components/dashboard/DashboardLayout.vue';
import DashboardReports from './components/dashboard/Admin/DashboardReports.vue';

// merchants in Dashboard admin
import IndexMerchants from './components/dashboard/Admin/Merchants/Index.vue';
import CreateMerchant from './components/dashboard/Admin/Merchants/Create.vue';
import ShowMerchant from './components/dashboard/Admin/Merchants/Show.vue';
import EditMerchant from './components/dashboard/Admin/Merchants/Edit.vue';
import MerchantsPayments from './components/dashboard/Admin/Merchants/Payments.vue';
import MerchantAddPayment from './components/dashboard/Admin/Merchants/AddPayments.vue';
import ShowProductsMerchant from './components/dashboard/Admin/Merchants/Products.vue';
import ShowOrdersMerchant from './components/dashboard/Admin/Merchants/Orders.vue';
import ShowPaymentsMerchant from './components/dashboard/Admin/Merchants/ShowPayments.vue';

// Deliveries in Dashboard admin
import IndexDeliveries from './components/dashboard/Admin/Deliveries/Index.vue';
import CreateDelivery from './components/dashboard/Admin/Deliveries/Create.vue';
import ShowDelivery from './components/dashboard/Admin/Deliveries/Show.vue';
import EditDelivery from './components/dashboard/Admin/Deliveries/Edit.vue';
import DeliveriesPayments from './components/dashboard/Admin/Deliveries/Payments.vue';
import DeliveryAddPayment from './components/dashboard/Admin/Deliveries/AddPayments.vue';
import ShowOrdersDelivery from './components/dashboard/Admin/Deliveries/Orders.vue';
import ShowPaymentsDelivery from './components/dashboard/Admin/Deliveries/ShowPayments.vue';

// Marketers in Dashboard admin
import IndexMarketers from './components/dashboard/Admin/Marketers/Index.vue';
import AddProductsMarketer from './components/dashboard/Admin/Marketers/AddProductsMarketer.vue';
import ProductsMarketer from './components/dashboard/Admin/Marketers/ProductsMarketer.vue';
import MarketersProfites from './components/dashboard/Admin/Marketers/MarketersProfites.vue';
import MarketersPayments from './components/dashboard/Admin/Marketers/MarketersPayments.vue';
import ShowMarketer from './components/dashboard/Admin/Marketers/Show.vue';
import ShowOrdersMarketer from './components/dashboard/Admin/Marketers/Orders.vue';


// Products in Dashboard admin
import IndexProducts from './components/dashboard/Admin/Products/Index.vue';
import AddProduct from './components/dashboard/Admin/Products/Create.vue';
import EditProduct from './components/dashboard/Admin/Products/Edit.vue';
import ShowProduct from './components/dashboard/Admin/Products/Show.vue';

// Orders in Dashboard admin
import IndexOrders from './components/dashboard/Admin/Orders/Index.vue';
import EditOrder from './components/dashboard/Admin/Orders/Edit.vue';
import ShowOrder from './components/dashboard/Admin/Orders/Show.vue';

//all profites
import AllProfites from './components/dashboard/Admin/Profites.vue';



/**
 * @merchant area
 * all components merchant
 */
import MerchantProducts from './components/dashboard/Merchant/Products/Index.vue';
import ShowMerchantProduct from './components/dashboard/Merchant/Products/Show.vue';
import ShowLowStockMerchantProduct from './components/dashboard/Merchant/Products/LowStock.vue';
import MerchantOrders from './components/dashboard/Merchant/Orders/Index.vue';
import ShowDueMerchantPayments from './components/dashboard/Merchant/Payments/Due.vue';
import ShowMadeMerchantPayments from './components/dashboard/Merchant/Payments/Made.vue';
import MerchantDashboard from './components/dashboard/Merchant/DashboardReports.vue';

/**
 * @Delivery area
 * all components merchant
 */
// import DeliveryProducts from './components/dashboard/Delivery/Products/Index.vue';
// import ShowDeliveryProduct from './components/dashboard/Delivery/Products/Show.vue';
// import ShowLowStockDeliveryProduct from './components/dashboard/Delivery/Products/LowStock.vue';
// import DeliveryOrders from './components/dashboard/Delivery/Orders/Index.vue';
// import ShowDueDeliveryPayments from './components/dashboard/Delivery/Payments/Due.vue';
// import ShowMadeDeliveryPayments from './components/dashboard/Delivery/Payments/Made.vue';
import DeliveryDashboard from './components/dashboard/Delivery/DashboardReports.vue';
import DeliveryOrdersDairy from './components/dashboard/Delivery/Orders/Dairy.vue';
import DeliveryOrdersWait from './components/dashboard/Delivery/Orders/Wait.vue';
import DeliveryOrdersProcess from './components/dashboard/Delivery/Orders/Process.vue';
import DeliveryOrdersComplete from './components/dashboard/Delivery/Orders/Complete.vue';
import DeliveryOrdersReturn from './components/dashboard/Delivery/Orders/Return.vue';
import DeliveryOrdersCancelled from './components/dashboard/Delivery/Orders/Cancelled.vue';
import DeliveryOrdersShow from './components/dashboard/Delivery/Orders/Show.vue';
import ShowDueDeliveryPayments from './components/dashboard/Delivery/Payments/Due.vue';
import ShowMadeDeliveryPayments from './components/dashboard/Delivery/Payments/Made.vue';
import DeliveryShowProduct from './components/dashboard/Delivery/Products/Show.vue';


/**
 * @Marketer area
 * all components Marketer
 */
import MarketerProducts from './components/dashboard/Marketer/Products/Index.vue';
import ShowMarketerProduct from './components/dashboard/Marketer/Products/Show.vue';
import ShowLowStockMarketerProduct from './components/dashboard/Marketer/Products/LowStock.vue';
import MarketerOrders from './components/dashboard/Marketer/Orders/Index.vue';
import ShowMarketerOrder from './components/dashboard/Marketer/Orders/Show.vue';
import MarketerEditOrder from './components/dashboard/Marketer/Orders/Edit.vue';
import ShowMarketerPayments from './components/dashboard/Marketer/Payments/Index.vue';
import MarketerDashboard from './components/dashboard/Marketer/DashboardReports.vue';
import MarketerCartsDashboard from './components/dashboard/Marketer/Cart/Index.vue';
import MarketerFavouritsDashboard from './components/dashboard/Marketer/Favourits/Index.vue';



const routes = [{
    path: '/',
    name: 'master-layout',
    component: MasterLayout,
    children: [{
            path: 'login',
            name: 'login',
            component: LoginForm,
            meta: {
                requiresAuth: false,
                PreventAuth: true
            }
        }, {
            path: 'register',
            name: 'register',
            component: RegisterForm,
            meta: {
                requiresAuth: false,
                PreventAuth: true
            }
        }, {
            path: 'dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                requiresAuth: true,
                AccountType: 'admin'
            },
            children: [{
                    path: 'dashboard-reports',
                    name: 'dashboard-reports',
                    component: DashboardReports,
                    meta: {
                        ar_name: 'الرئيسية',
                        menu_id: 'dashboard-reports',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                // Start merchants in Admin
                {
                    path: 'merchants/:page_no?',
                    name: 'index-merchants',
                    component: IndexMerchants,
                    meta: {
                        ar_name: 'عرض التجار',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'create-merchant',
                    name: 'create-merchant',
                    component: CreateMerchant,
                    meta: {
                        ar_name: 'اضافة تاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-merchant/:id',
                    name: 'show-merchant',
                    component: ShowMerchant,
                    meta: {
                        ar_name: 'عرض التاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'edit-merchant/:id',
                    name: 'edit-merchant',
                    component: EditMerchant,
                    meta: {
                        ar_name: 'تعديل التاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-products-merchant/:id/:page_no?',
                    name: 'show-products-merchant',
                    component: ShowProductsMerchant,
                    meta: {
                        ar_name: 'عرض  منتجات التاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-orders-merchant/:id/:page_no?',
                    name: 'show-orders-merchant',
                    component: ShowOrdersMerchant,
                    meta: {
                        ar_name: 'عرض  مبيعات التاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-payments-merchant/:id/:page_no?',
                    name: 'show-payments-merchant',
                    component: ShowPaymentsMerchant,
                    meta: {
                        ar_name: 'عرض  مدفوعات التاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'payments/:page_no?',
                    name: 'merchant-payments',
                    component: MerchantsPayments,
                    meta: {
                        ar_name: 'المدفوعات',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'merchant-add-payment/:id?',
                    name: 'merchant-add-payment',
                    component: MerchantAddPayment,
                    meta: {
                        ar_name: 'اضافة مدغوعات للتاجر',
                        menu_id: 'merchants',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                // End Merchants in Admin
                // Start Delievers in Admin
                {
                    path: 'deliveries/:page_no?',
                    name: 'index-deliveries',
                    component: IndexDeliveries,
                    meta: {
                        ar_name: 'عرض شركات الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'create-delivery',
                    name: 'create-delivery',
                    component: CreateDelivery,
                    meta: {
                        ar_name: 'اضافة شركة الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-delivery/:id',
                    name: 'show-delivery',
                    component: ShowDelivery,
                    meta: {
                        ar_name: 'عرض شركة الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-orders-delivery/:id',
                    name: 'show-orders-delivery',
                    component: ShowOrdersDelivery,
                    meta: {
                        ar_name: 'عرض طلبات شركة الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'edit-delivery/:id',
                    name: 'edit-delivery',
                    component: EditDelivery,
                    meta: {
                        ar_name: 'تعديل شركة الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'deliveries-payments',
                    name: 'deliveries-payments',
                    component: DeliveriesPayments,
                    meta: {
                        ar_name: 'المدفوعات',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'delivery-add-payment/:id?',
                    name: 'delivery-add-payment',
                    component: DeliveryAddPayment,
                    meta: {
                        ar_name: 'اضافة مدفوعات لشركة الشحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-payments-delivery/:id/:page_no?',
                    name: 'show-payments-delivery',
                    component: ShowPaymentsDelivery,
                    meta: {
                        ar_name: 'عرض  مدفوعات شركة السحن',
                        menu_id: 'deliveries',
                        requiresAuth: true,
                    }
                },
                // End Delievers in Admin
                // Start Marketers in Admin
                {
                    path: 'marketers/:page_no?',
                    name: 'marketers',
                    component: IndexMarketers,
                    meta: {
                        ar_name: 'عرض المسوقين',
                        menu_id: 'marketers',
                        requiresAuth: true,
                    }
                },
                {
                    path: 'show-marketer/:id/:page_no?',
                    name: 'show-marketer',
                    component: ShowMarketer,
                    meta: {
                        ar_name: 'عرض تفاصيل المسوق',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-orders-marketer/:id/:page_no?',
                    name: 'show-orders-marketer',
                    component: ShowOrdersMarketer,
                    meta: {
                        ar_name: 'عرض طلبات المسوق',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'add-products-marketer/:id/:page_no?',
                    name: 'add-products-marketer',
                    component: AddProductsMarketer,
                    meta: {
                        ar_name: 'اضافة منتجات للمسوق',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-products-marketer/:id/:page_no?',
                    name: 'show-products-marketer',
                    component: ProductsMarketer,
                    meta: {
                        ar_name: 'عرض منتجات المسوق',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'marketers-profites/:page_no?',
                    name: 'marketers-profites',
                    component: MarketersProfites,
                    meta: {
                        ar_name: 'أرباح المسوقين',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'marketers-payments',
                    name: 'marketers-payments',
                    component: MarketersPayments,
                    meta: {
                        ar_name: 'طلبات الدفع من المسوقين',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                // End Delievers in Admin

                // start Products in Admin
                {
                    path: 'products/:page_no?',
                    name: 'products',
                    component: IndexProducts,
                    meta: {
                        ar_name: 'عرض المنتجات',
                        menu_id: 'products',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'create-product',
                    name: 'create-product',
                    component: AddProduct,
                    meta: {
                        ar_name: 'اضافة منتج',
                        menu_id: 'products',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'edit-product/:id?',
                    name: 'edit-product',
                    component: EditProduct,
                    meta: {
                        ar_name: 'تعديل منتج',
                        menu_id: 'products',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-product/:id',
                    name: 'show-product/:id',
                    component: ShowProduct,
                    meta: {
                        ar_name: 'عرض منتج',
                        menu_id: 'products',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                // end Products in Admin
                // start Orders in Admin
                {
                    path: 'orders/:page_no?',
                    name: 'orders',
                    component: IndexOrders,
                    meta: {
                        ar_name: 'عرض الطلبات',
                        menu_id: 'orders',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'edit-order/:id?',
                    name: 'edit-order',
                    component: EditOrder,
                    meta: {
                        ar_name: 'تعديل الطلب',
                        menu_id: 'orders',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                {
                    path: 'show-order/:id',
                    name: 'show-order/:id',
                    component: ShowOrder,
                    meta: {
                        ar_name: 'عرض الطلب',
                        menu_id: 'orders',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                },
                // end Orders in Admin
                // all profites
                {
                    path: 'all-profites',
                    name: 'all-profites',
                    component: AllProfites,
                    meta: {
                        ar_name: 'الأرباح',
                        menu_id: 'all-profites',
                        requiresAuth: true,
                        AccountType: 'admin'
                    }
                }
            ]
        },
        {
            path: 'merchant',
            name: 'merchant',
            component: Dashboard,
            meta: {
                requiresAuth: true,
                AccountType: 'merchant'
            },
            children: [{
                    path: 'merchant-reports',
                    name: 'merchant-reports',
                    component: MerchantDashboard,
                    meta: {
                        ar_name: 'الرئيسية',
                        requiresAuth: true,
                        AccountType: 'merchant',
                        menu_id: 'merchant-reports',
                    },
                }, {
                    path: 'products/:page_no?/:filter_products?',
                    name: 'merchant-products',
                    component: MerchantProducts,
                    meta: {
                        ar_name: 'عرض المنتجات',
                        requiresAuth: true,
                        AccountType: 'merchant',
                        menu_id: 'merchant-products',
                    },
                },
                {
                    path: 'show-product/:id',
                    name: 'show-merchant-product',
                    component: ShowMerchantProduct,
                    meta: {
                        ar_name: 'عرض منتج',
                        menu_id: 'merchant-products',
                        requiresAuth: true,
                        AccountType: 'merchant'
                    }
                },
                {
                    path: 'lowstock-merchant-products',
                    name: 'lowstock-merchant-products',
                    component: ShowLowStockMerchantProduct,
                    meta: {
                        ar_name: 'عرض المنتجات المنتهية',
                        menu_id: 'lowstock-merchant-products',
                        requiresAuth: true,
                        AccountType: 'merchant'
                    }
                },
                // end of products
                {
                    path: 'orders/:page_no?',
                    name: 'merchant-orders',
                    component: MerchantOrders,
                    meta: {
                        ar_name: 'عرض الطلبات',
                        requiresAuth: true,
                        AccountType: 'merchant',
                        menu_id: 'merchant-orders',
                    },
                },
                // end of orders
                {
                    path: 'show-due-merchant-payments/:page_no?',
                    name: 'show-due-merchant-payments',
                    component: ShowDueMerchantPayments,
                    meta: {
                        ar_name: 'عرض الارباح المضافة',
                        requiresAuth: true,
                        AccountType: 'merchant',
                        menu_id: 'show-due-merchant-payments',
                    },
                },
                {
                    path: 'show-made-merchant-payments/:page_no?',
                    name: 'show-made-merchant-payments',
                    component: ShowMadeMerchantPayments,
                    meta: {
                        ar_name: 'عرض الارباح المسددة',
                        requiresAuth: true,
                        AccountType: 'merchant',
                        menu_id: 'show-made-merchant-payments',
                    },
                }
            ]
        }, {
            path: 'delivery',
            name: 'delivery',
            component: Dashboard,
            meta: {
                requiresAuth: true,
                AccountType: 'delivery'
            },
            children: [{
                    path: 'delivery-reports',
                    name: 'delivery-reports',
                    component: DeliveryDashboard,
                    meta: {
                        ar_name: 'الرئيسية',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-reports',
                    }
                }, {
                    path: 'delivery-return-orders/:page_no?',
                    name: 'delivery-return-orders',
                    component: DeliveryOrdersReturn,
                    meta: {
                        ar_name: 'الطلبات المرتجعة',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-return-orders',
                    }
                },
                {
                    path: 'delivery-dairy-orders/:page_no?',
                    name: 'delivery-dairy-orders',
                    component: DeliveryOrdersDairy,
                    meta: {
                        ar_name: 'الطلبات اليومية ',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-dairy-orders',
                    }
                },
                {
                    path: 'delivery-wait-orders/:page_no?',
                    name: 'delivery-wait-orders',
                    component: DeliveryOrdersWait,
                    meta: {
                        ar_name: 'الطلبات المنتظرة ',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-wait-orders',
                    }
                },
                {
                    path: 'delivery-process-orders/:page_no?',
                    name: 'delivery-process-orders',
                    component: DeliveryOrdersProcess,
                    meta: {
                        ar_name: 'الطلبات قيد التنفيذ ',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-process-orders',
                    }
                },
                {
                    path: 'delivery-complete-orders/:page_no?',
                    name: 'delivery-complete-orders',
                    component: DeliveryOrdersComplete,
                    meta: {
                        ar_name: 'الطلبات المكتملة ',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-complete-orders',
                    }
                },
                {
                    path: 'delivery-cancelled-orders/:page_no?',
                    name: 'delivery-cancelled-orders',
                    component: DeliveryOrdersCancelled,
                    meta: {
                        ar_name: 'الطلبات الملغية ',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-cancelled-orders',
                    }
                },
                {
                    path: 'delivery-show-orders/:id',
                    name: 'delivery-show-orders',
                    component: DeliveryOrdersShow,
                    meta: {
                        ar_name: 'عرض الطلب',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-show-orders',
                    }
                },
                {
                    path: 'show-due-delivery-payments/:page_no?',
                    name: 'show-due-delivery-payments',
                    component: ShowDueDeliveryPayments,
                    meta: {
                        ar_name: 'عرض الارباح المضافة',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'show-due-delivery-payments',
                    },
                },
                {
                    path: 'show-made-delivery-payments/:page_no?',
                    name: 'show-made-delivery-payments',
                    component: ShowMadeDeliveryPayments,
                    meta: {
                        ar_name: 'عرض الارباح المسددة',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'show-made-delivery-payments',
                    },
                },
                {
                    path: 'show-product/:id',
                    name: 'delivery-show-product',
                    component: DeliveryShowProduct,
                    meta: {
                        ar_name: 'عرض المنتج',
                        requiresAuth: true,
                        AccountType: 'delivery',
                        menu_id: 'delivery-show-product',
                    },
                }

            ]
        }, {
            path: 'marketer',
            name: 'marketer',
            component: Dashboard,
            meta: {
                requiresAuth: true,
                AccountType: 'marketer'
            },
            children: [{
                    path: 'marketer-reports',
                    name: 'marketer-reports',
                    component: MarketerDashboard,
                    meta: {
                        ar_name: 'الرئيسية',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-reports',
                    },
                }, {
                    path: 'products/:page_no?/:filter_products?',
                    name: 'marketer-products',
                    component: MarketerProducts,
                    meta: {
                        ar_name: 'عرض المنتجات',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-products',
                    },
                },
                {
                    path: 'show-product/:id',
                    name: 'show-marketer-product',
                    component: ShowMarketerProduct,
                    meta: {
                        ar_name: 'عرض منتج',
                        menu_id: 'marketer-products',
                        requiresAuth: true,
                        AccountType: 'marketer'
                    }
                },
                {
                    path: 'lowstock-marketer-products',
                    name: 'lowstock-marketer-products',
                    component: ShowLowStockMarketerProduct,
                    meta: {
                        ar_name: 'عرض المنتجات المنتهية',
                        menu_id: 'lowstock-marketer-products',
                        requiresAuth: true,
                        AccountType: 'marketer'
                    }
                },
                // end of products
                {
                    path: 'orders/:page_no?',
                    name: 'marketer-orders',
                    component: MarketerOrders,
                    meta: {
                        ar_name: 'عرض الطلبات',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-orders',
                    },
                },
                // end of orders
                {
                    path: 'payments/:page_no?',
                    name: 'marketer-payments',
                    component: ShowMarketerPayments,
                    meta: {
                        ar_name: 'طلبات سحب الارباح',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-payments',
                    },
                },
                {
                    path: 'carts/:action?/:order_id?',
                    name: 'marketer-carts',
                    component: MarketerCartsDashboard,
                    meta: {
                        ar_name: 'السلة',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-carts',
                    },
                },
                {
                    path: 'favourits/:page_no?',
                    name: 'marketer-favourits',
                    component: MarketerFavouritsDashboard,
                    meta: {
                        ar_name: 'المفضلة',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-favourits',
                    },
                },
                {
                    path: 'show-order/:id',
                    name: 'marketer-show-marketer',
                    component: ShowMarketerOrder,
                    meta: {
                        ar_name: 'عرض الطلب',
                        menu_id: 'marketers',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-orders',
                    }
                },
                {
                    path: 'edit-order/:order_id/:action?',
                    name: 'marketer-edit-order',
                    component: MarketerEditOrder,
                    meta: {
                        ar_name: 'تعديل الطلب',
                        requiresAuth: true,
                        AccountType: 'marketer',
                        menu_id: 'marketer-orders',
                    },
                }
            ]
        }
    ]
}];

//import.meta.env.BASE_URL
const router = createRouter({
    history: createWebHistory(),
    routes,
    base: '/',
});

router.beforeEach(async(to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (await Auth.authCheck()) {
            next();
            return;
        } else {
            router.push('/login');
        }
    } else {
        next();
    }

    if (to.matched.some(record => record.meta.PreventAuth)) {
        if (await Auth.authCheck()) {
            return false;
        } else {
            next();
        }
    } else {
        next();
    }
});


export default router;