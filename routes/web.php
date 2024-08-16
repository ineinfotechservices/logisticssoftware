<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ShippinglineController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\PortofLoadingController;
use App\Http\Controllers\PortofDestinationController;
use App\Http\Controllers\PlaceofReceiptController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ExporterController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\BookingDetailsController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\DeliveryAgentController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
    Route::get('consignee', [ConsigneeController::class, 'index'])->name('master.consignee.index');
    Route::get('consignee/add', [ConsigneeController::class, 'add'])->name('master.consignee.add');
    Route::get('consignee/edit/{id}', [ConsigneeController::class, 'edit'])->name('master.consignee.edit');
    Route::post('consignee/add/save', [ConsigneeController::class, 'save'])->name('master.consignee.save');
    Route::get('consignee/delete/{id}', [ConsigneeController::class, 'delete'])->name('master.consignee.delete');
    Route::post('consignee/edit/save/{id}', [ConsigneeController::class, 'update'])->name('master.consignee.update');

    Route::post('fetch/state', [StatesController::class, 'fetch_states'])->name('master.states.ajax');
    Route::post('fetch/city', [CitiesController::class, 'fetch_cities'])->name('master.cities.ajax');
    

    //shipping line master
    Route::get('shippingline', [ShippinglineController::class, 'index'])->name('master.shippingline.index');
    Route::get('shippingline/add', [ShippinglineController::class, 'add'])->name('master.shippingline.add');
    Route::get('shippingline/edit/{id}', [ShippinglineController::class, 'edit'])->name('master.shippingline.edit');
    Route::post('shippingline/add/save', [ShippinglineController::class, 'save'])->name('master.shippingline.save');
    Route::post('shippingline/edit/save/{id}', [ShippinglineController::class, 'update'])->name('master.shippingline.update');
    Route::get('shippingline/delete/{id}', [ShippinglineController::class, 'delete'])->name('master.shippingline.delete');

    // manage equipment type
    Route::get('equipmenttypes', [EquipmentTypeController::class, 'index'])->name('master.equipmenttype.index');
    Route::get('equipmenttypes/add', [EquipmentTypeController::class, 'add'])->name('master.equipmenttype.add');
    Route::get('equipmenttypes/edit/{id}', [EquipmentTypeController::class, 'edit'])->name('master.equipmenttype.edit');
    Route::post('equipmenttypes/add/save', [EquipmentTypeController::class, 'save'])->name('master.equipmenttype.save');
    Route::post('equipmenttypes/edit/save/{id}', [EquipmentTypeController::class, 'update'])->name('master.equipmenttype.update');
    Route::get('equipmenttypes/delete/{id}', [EquipmentTypeController::class, 'delete'])->name('master.equipmenttype.delete');

    // manage port of loading 
    Route::get('portofloading', [PortofLoadingController::class, 'index'])->name('master.portofloading.index');
    Route::get('portofloading/add', [PortofLoadingController::class, 'add'])->name('master.portofloading.add');
    Route::get('portofloading/edit/{id}', [PortofLoadingController::class, 'edit'])->name('master.portofloading.edit');
    Route::post('portofloading/add/save', [PortofLoadingController::class, 'save'])->name('master.portofloading.save');
    Route::post('portofloading/edit/save/{id}', [PortofLoadingController::class, 'update'])->name('master.portofloading.update');
    Route::get('portofloading/delete/{id}', [PortofLoadingController::class, 'delete'])->name('master.portofloading.delete');


    // manage port of Destination 
    Route::get('portofdestination', [PortofDestinationController::class, 'index'])->name('master.portofdestination.index');
    Route::get('portofdestination/add', [PortofDestinationController::class, 'add'])->name('master.portofdestination.add');
    Route::get('portofdestination/edit/{id}', [PortofDestinationController::class, 'edit'])->name('master.portofdestination.edit');
    Route::post('portofdestination/add/save', [PortofDestinationController::class, 'save'])->name('master.portofdestination.save');
    Route::post('portofdestination/edit/save/{id}', [PortofDestinationController::class, 'update'])->name('master.portofdestination.update');
    Route::get('portofdestination/delete/{id}', [PortofDestinationController::class, 'delete'])->name('master.portofdestination.delete');


    // Manage place of receipt
    Route::get('placeofreceipt', [PlaceofReceiptController::class, 'index'])->name('master.placeofreceipt.index');
    Route::get('placeofreceipt/add', [PlaceofReceiptController::class, 'add'])->name('master.placeofreceipt.add');
    Route::get('placeofreceipt/edit/{id}', [PlaceofReceiptController::class, 'edit'])->name('master.placeofreceipt.edit');
    Route::post('placeofreceipt/add/save', [PlaceofReceiptController::class, 'save'])->name('master.placeofreceipt.save');
    Route::post('placeofreceipt/edit/save/{id}', [PlaceofReceiptController::class, 'update'])->name('master.placeofreceipt.update');
    Route::get('placeofreceipt/delete/{id}', [PlaceofReceiptController::class, 'delete'])->name('master.placeofreceipt.delete');


    // Country
    Route::get('country', [CountriesController::class, 'index'])->name('master.country.index');
    Route::get('country/add', [CountriesController::class, 'add'])->name('master.country.add');
    Route::get('country/edit/{id}', [CountriesController::class, 'edit'])->name('master.country.edit');
    Route::post('country/add/save', [CountriesController::class, 'save'])->name('master.country.save');
    Route::post('country/edit/save/{id}', [CountriesController::class, 'update'])->name('master.country.update');
    Route::get('country/delete/{id}', [CountriesController::class, 'delete'])->name('master.country.delete');

    // States
    Route::get('state', [StatesController::class, 'index'])->name('master.state.index');
    Route::get('state/add', [StatesController::class, 'add'])->name('master.state.add');
    Route::get('state/edit/{id}', [StatesController::class, 'edit'])->name('master.state.edit');
    Route::post('state/add/save', [StatesController::class, 'save'])->name('master.state.save');
    Route::post('state/edit/save/{id}', [StatesController::class, 'update'])->name('master.state.update');
    Route::get('state/delete/{id}', [StatesController::class, 'delete'])->name('master.state.delete');

    // City
    Route::get('city', [CitiesController::class, 'index'])->name('master.city.index');
    Route::get('city/add', [CitiesController::class, 'add'])->name('master.city.add');
    Route::get('city/edit/{id}', [CitiesController::class, 'edit'])->name('master.city.edit');
    Route::post('city/add/save', [CitiesController::class, 'save'])->name('master.city.save');
    Route::post('city/edit/save/{id}', [CitiesController::class, 'update'])->name('master.city.update');
    Route::get('city/delete/{id}', [CitiesController::class, 'delete'])->name('master.city.delete');


    // Exporter
    Route::get('exporter', [ExporterController::class, 'index'])->name('master.exporter.index');
    Route::get('exporter/add', [ExporterController::class, 'add'])->name('master.exporter.add');
    Route::get('exporter/edit/{id}', [ExporterController::class, 'edit'])->name('master.exporter.edit');
    Route::post('exporter/save', [ExporterController::class, 'save'])->name('master.exporter.save');
    Route::post('exporter/document/save', [ExporterController::class, 'document_save'])->name('master.exporter.docssave');
    Route::post('exporter/document/editsave', [ExporterController::class, 'document_save_edit'])->name('master.exporter.saveedit');
    Route::post('exporter/document/delete', [ExporterController::class, 'document_delete_tmp'])->name('master.exporter.deletetmp');
    Route::post('exporter/document/editdelete', [ExporterController::class, 'document_delete_edit'])->name('master.exporter.deleteedit');
    Route::post('exporter/edit/save/{id}', [ExporterController::class, 'update'])->name('master.exporter.update');
    Route::get('exporter/delete/{id}', [ExporterController::class, 'delete'])->name('master.exporter.delete');


    Route::get('notify', [NotifyController::class, 'index'])->name('master.notify.index');
    Route::get('notify/add', [NotifyController::class, 'add'])->name('master.notify.add');
    Route::get('notify/edit/{id}', [NotifyController::class, 'edit'])->name('master.notify.edit');
    Route::post('notify/add/save', [NotifyController::class, 'save'])->name('master.notify.save');
    Route::post('notify/edit/save/{id}', [NotifyController::class, 'update'])->name('master.notify.update');
    Route::get('notify/delete/{id}', [NotifyController::class, 'delete'])->name('master.notify.delete');


    Route::get('deliveryagent', [DeliveryAgentController::class, 'index'])->name('master.deliveryagent.index');
    Route::get('deliveryagent/add', [DeliveryAgentController::class, 'add'])->name('master.deliveryagent.add');
    Route::get('deliveryagent/edit/{id}', [DeliveryAgentController::class, 'edit'])->name('master.deliveryagent.edit');
    Route::post('deliveryagent/add/save', [DeliveryAgentController::class, 'save'])->name('master.deliveryagent.save');
    Route::post('deliveryagent/edit/save/{id}', [DeliveryAgentController::class, 'update'])->name('master.deliveryagent.update');
    Route::get('deliveryagent/delete/{id}', [DeliveryAgentController::class, 'delete'])->name('master.deliveryagent.delete');


    // Job Management
    Route::get('jobs', [JobsController::class, 'index'])->name('master.jobs.index');
    Route::get('jobs/add', [JobsController::class, 'add'])->name('master.jobs.add');
    Route::get('jobs/edit/{id}', [JobsController::class, 'edit'])->name('master.jobs.edit');
    Route::post('jobs/save', [JobsController::class, 'save'])->name('master.jobs.save');
    Route::post('jobs/edit/save/{id}', [JobsController::class, 'update'])->name('master.jobs.update');
    Route::get('jobs/delete/{id}', [JobsController::class, 'delete'])->name('master.jobs.delete');


    // booking details
    Route::get('bookingdetails', [BookingDetailsController::class, 'index'])->name('master.booking.index');
    Route::get('bookingdetails/add', [BookingDetailsController::class, 'add'])->name('master.booking.add');
    Route::get('jobookingdetailsbs/edit/{id}', [BookingDetailsController::class, 'edit'])->name('master.booking.edit');
    Route::get('jobookingdetailsbs/view/{id}', [BookingDetailsController::class, 'view'])->name('master.booking.view');
    Route::post('bookingdetails/save', [BookingDetailsController::class, 'save'])->name('master.booking.save');
    Route::post('bookingdetails/edit/save/{id}', [BookingDetailsController::class, 'update'])->name('master.booking.update');
    Route::post('momentdetail/edit/save/{id}', [BookingDetailsController::class, 'moment_detail_update'])->name('master.momentdetails.update');
    Route::post('bookingdetails/addvesselhistory/save/{id}', [BookingDetailsController::class, 'addvesselhistory'])->name('master.booking.addvesselhistory');
    Route::get('bookingdetails/delete/{id}', [BookingDetailsController::class, 'delete'])->name('master.booking.delete');
    Route::get('bookingdetails/listcompleted', [BookingDetailsController::class, 'completedlist'])->name('master.booking.completedlist');
    Route::get('bookingdetails/completed/{id}', [BookingDetailsController::class, 'completed'])->name('master.booking.completed');    
    Route::get('bookingdeail/documentedit/{id}', [BookingDetailsController::class, 'documentedit'])->name('master.booking.documentedit');
    Route::get('bookingdeail/documentfilesedit/{id}', [BookingDetailsController::class, 'documentfilesedit'])->name('master.booking.documentfilesedit');
    Route::post('bookingdeail/documentfiledelete/{id}', [BookingDetailsController::class, 'deleteotherdocumenfile'])->name('master.booking.deleteotherdocumenfile');
    Route::get('bookingdeail/documentinvoice/{id}', [BookingDetailsController::class, 'documentinvoice'])->name('master.booking.documentinvoice');
    Route::post('bookingdeail/documentupdate/{id}', [BookingDetailsController::class, 'documentupdate'])->name('master.booking.documentupdate');
    Route::post('bookingdeail/documentfileupdate/{id}', [BookingDetailsController::class, 'documentfileupdate'])->name('master.booking.documentfileupdate');
    Route::post('bookingdeail/documentmoemntupdate/{id}', [BookingDetailsController::class, 'documentmoemntupdate'])->name('master.booking.documentmoemntupdate');
    Route::post('bookingdetails/unlockseal', [BookingDetailsController::class, 'unlockseal'])->name('master.booking.unlockseal');
    Route::post('bookingdetails/transhipment/save/{id}', [BookingDetailsController::class, 'transhipment_save'])->name('master.booking.transhipment_save');
    Route::post('bookingdetails/get_transport/detail/{id}', [BookingDetailsController::class, 'get_transportment_details'])->name('master.booking.get_transportment_details');
    Route::post('bookingdetails/update_transport/{id}', [BookingDetailsController::class, 'update_transportment'])->name('master.booking.update_transportment');
    Route::post('bookingdetails/delete_transhpment/{id}', [BookingDetailsController::class, 'delete_transhpment'])->name('master.booking.delete_transhpment');
    Route::post('getshipper/info/{id}', [BookingDetailsController::class, 'getshipperinfo'])->name('master.booking.getshipperinfo');
    Route::post('consignee/info/{id}', [BookingDetailsController::class, 'consignee_data'])->name('master.booking.consignee_data');
    Route::post('deliveryagent/info/{id}', [DeliveryAgentController::class, 'delivery_agent_data'])->name('master.deliveryagent.data');
    Route::post('jobookingdetailsbs/documentvesseldetail/{id}', [BookingDetailsController::class, 'documentvesseldetail'])->name('master.booking.documentvesseldetail');
    Route::post('jobookingdetailsbs/cargo_details/{id}', [BookingDetailsController::class, 'cargo_details'])->name('master.booking.cargo_details');


    // follow up
    Route::get('followup', [FollowupController::class, 'index'])->name('master.followup.index');
    Route::get('followup/add', [FollowupController::class, 'add'])->name('master.followup.add');
    Route::get('followup/addnext/{id}', [FollowupController::class, 'addnext'])->name('master.followup.addnext');
    Route::post('followup/add_save', [FollowupController::class, 'add_save'])->name('master.followup.add_save');
    Route::post('followup/add_next_followup/{id}', [FollowupController::class, 'add_next_followup'])->name('master.followup.add_next_followup');
    Route::get('followup/delete/{id}', [FollowupController::class, 'delete_followups'])->name('master.followup.delete');
    Route::get('followup/view/{id}', [FollowupController::class, 'view_followups'])->name('master.followup.view');
    
    
    // Users
    Route::get('users', [UsersController::class, 'index'])->name('master.users.index');
    Route::get('users/add', [UsersController::class, 'add'])->name('master.users.add');
    Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('master.users.edit');
    Route::post('users/save', [UsersController::class, 'save'])->name('master.users.save');
    Route::post('users/edit/save/{id}', [UsersController::class, 'update'])->name('master.users.update');
    Route::get('users/delete/{id}', [UsersController::class, 'delete'])->name('master.users.delete');

    
    Route::get('users/profile', [UsersController::class, 'profile'])->name('master.profile.show');
    Route::post('users/profile', [UsersController::class, 'profile_update'])->name('master.profile.update');
    Route::get('logout', [UsersController::class, 'logout'])->name('users.logout');
});

Route::get('login', [LoginController::class, 'login'])->name('users.login');
Route::post('authlog', [LoginController::class, 'logincheck'])->name('auth.login');
Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();


