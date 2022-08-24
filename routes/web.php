<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\chatController;

use App\Models\User;
use App\Models\Land;
use App\Models\Permission;
use App\Models\Message;

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

Route::group(['middleware' => 'web'], function () {
    Route::get('/changeLang/{lang}', function ($lang) {
        session(['lang' => $lang]);
        return back();
    })->where([
        'lang' => 'es|en'
    ]);
});

Route::get('logout', function(){
    Auth::logout();

    return redirect('login');
});
Route::get('migration', [BackendController::class,'migration']);

Route::get('login', ['uses' => function () {
    return view('login');
}, 'as' => 'login']);

Route::post('login', [LoginController::class,'login']);

Route::group([/*'prefix' => 'admin',*/ 'middleware' => 'auth'], function() {
    //
    Route::get('/addStatus', [BackendController::class,'addStatus']);
    Route::get('/deleteStatus/{id}', [BackendController::class,'deleteStatus']);
    Route::post('/saveStatus', [BackendController::class,'saveStatus']);


    Route::post('/saveInput', [BackendController::class,'saveInput']);
    Route::post('/editInput', [BackendController::class,'editInput']);
    Route::get('/addLand', [BackendController::class,'addLand']);
    Route::post('/saveLand', [BackendController::class,'saveLand']);
    Route::get('/deleteLand/{id}', [BackendController::class,'deleteLand']);
    Route::get('/delete-input/{id}', [BackendController::class,'deleteInput']);

    Route::get('/deleteGuarantee/{id}', [PermissionsController::class,'deleteGuarantee']);

    Route::post('/saveLandPermission', [PermissionsController::class,'saveLandPermission']);

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/lands', function () {
        return view('lands');
    });

    Route::get('/chat', function () {
        $m = Message::where('to',null)->get();

        foreach ($m as $key => $value) {
            $seen = $value->seen;
            $seen[] = (string)Auth::id();
            $value->seen = array_unique($seen);
            $value->save();
        }
        return view('chat');
    });

    Route::get('/projects', function () {
        return view('projects');
    });

    Route::get('/project/{id}', function ($id) {
        $p = Permission::find($id);
        return view('project',compact('p'));
    });

    Route::get('/total', function () {
        return view('total');
    });

    Route::get('/guarantee', function () {
        return view('guarantee');
    });

    Route::get('/administration-organ', function () {
        return view('administration');
    });

    Route::get('/proxies', function () {
        return view('proxies');
    });

    Route::get('/subcontractors', function () {
        return view('subcontractors');
    });

    Route::get('/partners', function () {
        return view('partners');
    });

    Route::get('/documents', function () {
        return view('documents');
    });
    Route::get('/contacts', function () {
        return view('contacts');
    });

    Route::get('/new-administration', function () {
        return view('new-administration');
    });

    Route::get('/edit-administration/{id}', function ($id) {
        $a = App\Models\Administration::find($id);
        return view('new-administration',compact('a'));
    });
    Route::post('/saveDocument', [BackendController::class,'saveDocument']);


    Route::get('/technologies/{id?}', [BackendController::class,'technologies']);
    Route::post('/update-technology', [BackendController::class,'updateTechnology']);
    Route::post('/save-technology', [BackendController::class,'saveTechnology']);
    Route::get('/delete-technology/{id}', [BackendController::class,'deleteTechnology']);




    Route::get('/addPartner', [BackendController::class,'addPartner']);
    Route::get('/deletePartner/{id}', [BackendController::class,'deletePartner']);
    Route::post('/savePartner', [BackendController::class,'savePartner']);
    Route::get('/addSubcontractor', [BackendController::class,'addSubcontractor']);
    Route::post('/saveSubcontractor', [BackendController::class,'saveSubcontractor']);

    Route::post('/savePermissionInput', [PermissionsController::class,'savePermissionInput']);
    Route::post('/editPermissionInput', [PermissionsController::class,'editPermissionInput']);
    Route::get('/deleteProject/{id}', [PermissionsController::class,'deleteProject']);

    Route::post('/addNewProject', [PermissionsController::class,'addNewProject']);

    Route::get('/addActivitySection/{id}', [PermissionsController::class,'addSection']);
    Route::post('/saveActivitySection', [PermissionsController::class,'saveSection']);
    Route::post('/createActivity', [PermissionsController::class,'createActivity']);
    Route::post('/saveActivity', [PermissionsController::class,'saveActivity']);
    Route::get('/deleteActivity/{id}', [PermissionsController::class,'deleteActivity']);
    
    Route::post('/uploadFile', [PermissionsController::class,'uploadFile']);
    Route::post('/uploadFileProject', [PermissionsController::class,'uploadFileProject']);

    Route::post('/saveValueProject', [PermissionsController::class,'saveValueProject']);

    Route::get('/prepareKML/{id}', [BackendController::class,'prepareKML']);
    
    Route::post('/addNewGuarantee', [PermissionsController::class,'addNewGuarantee']);
    Route::post('/saveGuarantee', [PermissionsController::class,'saveGuarantee']);
    Route::post('/uploadExcel', [BackendController::class,'uploadExcel']);
    Route::post('/uploadExcel2', [BackendController::class,'uploadExcel2']);
    Route::post('/uploadExcelProject', [BackendController::class,'uploadExcelProject']);

    Route::post('/saveLatLng/{id}', [BackendController::class,'saveLatLng']);
    Route::post('/findInformation', [BackendController::class,'findInformation']);

    /**/
    Route::get('/addContact/{id?}', [BackendController::class,'addContact']);
    Route::post('/saveContact', [BackendController::class,'saveContact']);
    Route::get('/deleteContact/{id}', [BackendController::class,'deleteContact']);

    Route::get('/addSection', [BackendController::class, 'addSection']);
    Route::post('/updateSection', [BackendController::class, 'updateSection']);
    Route::get('/deleteSection/{id}', [BackendController::class, 'deleteSection']);
    
    Route::get('/deleteAdministration/{id}', [BackendController::class,'deleteAdministration']);


    // Route::get('/addAdministrative', [BackendController::class,'addAdministrative']);


    Route::post('/save-administrative', [BackendController::class,'saveAdministrative']);
    Route::post('/update-administrative', [BackendController::class,'updateAdministrative']);

    Route::post('/saveAdministrationDocument', [BackendController::class,'saveAdministrationDocument']);
    
    Route::get('/contract-documents', [BackendController::class,'ContractDocuments']);
    Route::get('/budget-documents', [BackendController::class,'BudgetDocuments']);
    Route::post('/saveContractDocument', [BackendController::class,'saveContractDocument']);

    Route::get('/compliance-documents', [BackendController::class,'ComplianceDocuments']);
    Route::post('/saveComplianceDocument', [BackendController::class,'saveComplianceDocument']);
    Route::post('/saveBudgetDocument', [BackendController::class,'saveBudgetDocument']);
    
    Route::post('/generate-report', [BackendController::class,'generateReport']);
    Route::get('/summary-report', [BackendController::class,'summaryReport']);
    Route::get('/projects-report', [BackendController::class,'projectsReport']);
});

Route::group(['middleware' => 'web'], function () {
    // Route::auth();
    Route::get('/home', function(){
        return view('home');
    });
});
Route::post('sendmessage', [chatController::class,'sendMessage']);
Route::get('loadMessages/{id?}', [chatController::class,'loadMessages']);
Route::post('setSeen', [chatController::class, 'setSeen']);

Route::get('profile', [LoginController::class,'profile']);
Route::post('updateProfile', [LoginController::class,'updateProfile']);

Route::post('downloadPDF/{id}', [BackendController::class,'downloadPDF']);
Route::get('change-status/{id}', [BackendController::class,'changeStatus']);
/**/
Route::post('saveDataLand', [BackendController::class,'saveDataLand']);
/**/
Route::post('downloadPDFMaps', [BackendController::class,'downloadPDFMaps']);

/**/
Route::get('delete-administrative-document/{id}', [BackendController::class,'deleteAdministrativeDocument']);
Route::get('delete-contract-document/{id}', [BackendController::class,'deleteContractDocument']);
Route::get('delete-compliance-document/{id}', [BackendController::class,'deleteComplianceDocument']);
Route::get('delete-budget-document/{id}', [BackendController::class,'deleteBudgetDocument']);
Route::get('delete-document/{id}', [BackendController::class,'deleteDocument']);


Route::get('m_a-documents', [BackendController::class, 'MaDocuments']);
Route::post('saveMaDocument', [BackendController::class, 'saveMaDocument']);
Route::get('delete-ma-document/{id}', [BackendController::class, 'deleteMaDocument']);
Route::get('other-information', [BackendController::class, 'OtherInformations']);
Route::post('saveOtherInformation', [BackendController::class, 'saveOtherInformation']);
Route::get('delete-other-information/{id}', [BackendController::class, 'deleteOtherInformation']);


Route::post('saveTranslation', [BackendController::class, 'saveTranslation']);


Route::get('getTemplate', [BackendController::class, 'getTemplate']);
Route::get('getTemplateEdit/{id}', [BackendController::class, 'getTemplateEdit']);
Route::get('resetLocations', [BackendController::class, 'resetLocations']);


Route::post('saveDataUrl', [BackendController::class, 'saveDataUrl']);

Route::get('getTechnology/{id}', [BackendController::class, 'getTechnology']);