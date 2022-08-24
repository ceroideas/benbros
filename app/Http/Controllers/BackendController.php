<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Subcontractor;
use App\Models\Contact;
use App\Models\ContactSection;
use App\Models\Administration;
use App\Models\AdministrationDocument;
use App\Models\BudgetDocument;
use App\Models\ContractDocument;
use App\Models\ComplianceDocument;
use App\Models\Land;
use App\Models\Input;
use App\Models\InputOption;
use App\Models\ActivityDocument;
use App\Models\ActivitySection;
use App\Models\Activity;
use App\Models\Section;
use App\Models\Document;
use App\Models\Permission;
use App\Models\Endorsement;
use App\Models\Status;
use App\Models\User;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Translate;
use App\Models\Technology;

use App\Models\OtherInformation;
use App\Models\MaDocument;
use Carbon\Carbon;

use ZipArchive;

use Illuminate\Support\Str;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Mail;
use Excel;

use PDF;
use Auth;

use App\Imports\LandsImport;
use App\Imports\GuaranteeImport;
use App\Imports\ProjectImport;
use App\Exports\LandsExport;
use App\Exports\SummaryExport;
use App\Exports\ProjectsExport;

class BackendController extends Controller
{
    public function downloadPDF(Request $r, $id)
    {
        $l = Land::find($id);
        $p = Permission::where('land_id',$id)->first();
        $a = Endorsement::where('land_id',$id)->first();

        $pdf = PDF::setPaper('legal', 'portrait');

        // return view('pdf-report', compact('l','p','a'));

        $pdf->loadView('pdf-report', compact('l','p','a','r'));

        return $pdf->download( Str::slug('reporte terreno '.$l->id.' '.$l->name.' '.Carbon::now()->format('d-m-Y H_i_s'),'-').'.pdf');
    }

    public function downloadPDFMaps(Request $r)
    {
        // return $r->all();

        $pdf = PDF::setPaper('letter', 'landscape');

        // return view('map-report', compact('r'));

        $pdf->loadView('map-report', compact('r'));

        return $pdf->download( Str::slug('reporte mapa '.Carbon::now()->format('d-m-Y H_i_s'),'-').'.pdf');
    }
    //
    public function uploadExcel(Request $r)
    {
        if ($r->hasFile('file')) {
            $r->file->move(public_path().'/uploads/excel','lands.xlsx');
            Excel::import(new LandsImport, public_path().'/uploads/excel/lands.xlsx');
        }

        return back()->with('msj',trans('layout.excel_loaded'));
    }
    public function uploadExcel2(Request $r)
    {
        // Endorsement::truncate();
        if ($r->hasFile('file')) {
            $r->file->move(public_path().'/uploads/excel','guarantee.xlsx');
            Excel::import(new GuaranteeImport, public_path().'/uploads/excel/guarantee.xlsx');
        }

        return back()->with('msj',trans('layout.excel_loaded'));
    }

    public function uploadExcelProject(Request $r)
    {
        if ($r->hasFile('file')) {
            $r->file->move(public_path().'/uploads/excel','activities.xlsx');
            Excel::import(new ProjectImport($r->id), public_path().'/uploads/excel/activities.xlsx');
        }

        return back()->with('msj',trans('layout.excel_loaded'));
    }

    public function generateReport(Request $r)
    {
        return Excel::download(new LandsExport($r->ids,$r->id), 'lands-export.xlsx');
    }

    public function summaryReport()
    {
        return Excel::download(new SummaryExport, 'summary-export.xlsx');
    }
    public function projectsReport()
    {
        return Excel::download(new ProjectsExport, 'projects-export.xlsx');
    }

    public function changeStatus($id)
    {
        $i = Input::find($id);
        $i->status = $i->status ? 0 : 1;
        $i->save();

        $inputs = Input::where('table','land')->where('status',1)->orderBy('order','asc')->get();

        return [
            $i->status
            ,
            view('includes.lands')->render(),
            view('includes.header-changed',compact('inputs'))->render()
        ];
    }

    public function generateNotifications(Request $r)
    {
        Notification::where('type',$r->notifications[0]['type'])->delete();

        foreach ($r->notifications as $key => $value) {
            $n = new Notification;
            $n->type = $value['type'];
            $n->duration = $value['duration'];
            $n->project_name = $value['project'];
            $n->notification_date = $value['end'];
            $n->save();
        }
    }

    public function migration()
    {

        return Activity::all();

        Schema::dropIfExists('project_documents');
        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        // Schema::create('ma_documents', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('url')->nullable();
        //     $table->timestamps();
        //     //
        // });

        /*Schema::dropIfExists('other_information');

        Schema::create('other_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->timestamps();
            //
        });*/

        /*Schema::dropIfExists('technologies');

        Schema::create('technologies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('icon')->nullable();
            $table->string('map_marker')->nullable();
            $table->string('report_color')->nullable();

            $table->integer('n_project')->nullable();
            $table->integer('n_mwn')->nullable();
            $table->integer('n_mwp')->nullable();
            $table->integer('tenders')->nullable();
            $table->integer('ac_req')->nullable();

            $table->timestamps();
            //
        });

        $ts = [
            ["name" => "Proyectos FV", "name_en" => "PV Projects", "icon" => url('fv.png'), "map_marker" => url('fv_marker.png'),
            "n_project" => 1,"n_mwn" => 1,"n_mwp" => 1,"tenders" => 1,"ac_req" => 1, "report_color" => "red"],

            ["name" => "Proyectos Green Hydrogen", "name_en" => "Green Hydrogen Projects", "icon" => url('gh.png'), "map_marker" => url('gh_marker.png'),
            "n_project" => 1,"n_mwn" => 1,"n_mwp" => 1,"tenders" => 1,"ac_req" => 1, "report_color" => "green"],

            ["name" => "Pryectos Storage", "name_en" => "Storage Projects", "icon" => url('st.png'), "map_marker" => url('st_marker.png'),
            "n_project" => 1,"n_mwn" => 1,"n_mwp" => 1,"tenders" => 1,"ac_req" => 1, "report_color" => "black"],

            ["name" => "Data Center", "name_en" => "Data Center", "icon" => url('dc.png'), "map_marker" => url('dc_marker.png'),
            "n_project" => 1,"n_mwn" => 1,"n_mwp" => 1,"tenders" => 0,"ac_req" => 0, "report_color" => "yellow"],
        ];

        foreach($ts as $t)
        {
            $tech = new Technology;
            $tech->name = $t['name'];
            $tech->name_en = $t['name_en'];
            $tech->icon = $t['icon'];
            $tech->map_marker = $t['map_marker'];
            $tech->report_color = $t['report_color'];
            $tech->n_project = $t['n_project'];
            $tech->n_mwn = $t['n_mwn'];
            $tech->n_mwp = $t['n_mwp'];
            $tech->tenders = $t['tenders'];
            $tech->ac_req = $t['ac_req'];
            $tech->save();
        }*/

        return "ok";

        // Schema::create('budget_documents', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('url')->nullable();
        //     $table->timestamps();
        //     //
        // });

        // Message::truncate();
        // return "";
        // Schema::dropIfExists('compliance_documents');
        // Schema::create('compliance_documents', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('url')->nullable();
        //     $table->integer('order')->nullable();
        //     $table->timestamps();
        //     //
        // });
        // return User::select("email")->get();
        // return Message::all();
        // return Message::where('to',null)->
        //     where(function($q){
        //         $q->
        //         where('seen',null)->
        //         orWhere('seen','not like',"%\"".Auth::id()."\"%");
        //     })
        //     ->get();
        // /*foreach (Message::all() as $key => $value) {
        //     $value->seen = null;
        //     $value->save();
        // }*/
        // return Message::all();
        // return Message::where('to',null)->
        // where(function($q){
        //     $q->
        //     where('seen',null)->
        //     orWhere('seen','not like',"%\"{Auth::id()}\"%");
        // })
        // ->count();
        // Endorsement::truncate();
        // Land::truncate();
        // Permission::truncate();
        // Activity::truncate();
        // ActivitySection::truncate();
        // Land::whereIn('id',[354,355,356,357,358,359,360,361,362])->delete();
        /*Schema::dropIfExists('translates');
        Schema::create('translates', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->nullable();
            $table->string('table')->nullable();
            $table->string('column')->nullable();
            $table->integer('ref_id')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
        });*/
        /*$not = Notification::where('duration','dia anterior')->get();

        foreach ($not as $key => $value) {
            echo $value->notification_date.'<br>';
        }*/
        // Schema::create('notifications', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('type')->nullable();
        //     $table->string('duration')->nullable();
        //     $table->string('project_name')->nullable();
        //     $table->string('notification_date')->nullable();
        //     $table->text('views')->nullable();
        //     $table->timestamps();
        //     //
        // });
        /*Schema::create('subcontractors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            //
        });
        return User::select('email')->get();

        foreach (ContractDocument::all() as $key => $value) {
            $value->type = 1;
            $value->save();
        }*/

        /*Schema::table('lands', function(Blueprint $table) {
            //
            $table->string('becoming_date')->nullable();
        });*/
        
        // Schema::table('contract_documents', function(Blueprint $table) {
        //     //
        //     $table->integer('type')->nullable();
        // });

        /*return ;

        Schema::dropIfExists('project_documents');
        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_id')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        return "";*/

        /*$in = Input::all();

        foreach ($in as $key => $value) {
            $value->status = 1;
            $value->save();
        }

        return "ok";*/

        $names = [[
            "name" => "Francisco Ruiz",
            "email" => "francisco.ruiz@benbros.es",
            "position" => "DIRECTOR GENERAL",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Belén Amunátegui",
            "email" => "belen.amunategui@benbros.es",
            "position" => "DESARROLLO DE NEGOCIO",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Juan Carlos Chacón",
            "email" => "juancarlos.chacon@benbros.es",
            "position" => "DIRECTOR TÉCNICO",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Alejandro  Martínez",
            "email" => "alejandro.martinez@benbros.es",
            "position" => "FINANCIERO",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Diego Hernández-Gil",
            "email" => "diego.hernandezgil@benbros.es",
            "position" => "LEGAL",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Maite  Moreno Galdos",
            "email" => "Maite.Moreno@benbros.es",
            "position" => "LEGAL",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Fernando  Álvarez",
            "email" => "fernando.alvarez@benbros.es",
            "position" => "TERRENOS",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Arantxa Ferragut",
            "email" => "arantxa.ferragut@benbros.es",
            "position" => "DIRECTORA FINANCIERA",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Ignacio Aguirre",
            "email" => "ignacio.aguirre@benbros.es",
            "position" => "M&A",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Ignacio Guerrero",
            "email" => "ignacio.guerrero@benbros.es",
            "position" => "TERRENOS",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ],
        [
            "name" => "Isabel Ibañez",
            "email" => "isabel.ibanez@benbros.es",
            "position" => "DESARROLLO DE NEGOCIO",
            "avatar" => "https://e7.pngegg.com/pngimages/134/822/png-clipart-computer-icons-business-man-people-logo.png"
        ]];

        foreach (User::all() as $key => $value) {
            copy($names[$key]['avatar'], public_path().'/uploads/avatars/'.basename($names[$key]['avatar']));
            $value->name = $names[$key]['name'];
            $value->email = $names[$key]['email'];
            $value->position = $names[$key]['position'];
            $value->avatar = basename($names[$key]['avatar']);
            $value->password = bcrypt('password');
            $value->save();
        }

        return User::all();

        Schema::create('contract_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->timestamps();
            //
        });

        return "ok";
        Schema::table('contacts', function(Blueprint $table) {
            //
            $table->string('position')->nullable();
        });

        Message::truncate();
        return Message::all();

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->text('seen')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            //
        });

        /*Schema::table('users', function(Blueprint $table) {
            //
            $table->string('avatar')->nullable();
            $table->string('position')->nullable();
        });*/
        return "Ok";
        
        Schema::create('contact_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            //
        });

        Schema::table('contacts', function(Blueprint $table) {
            //
            $table->integer('contact_section_id')->nullable();
        });
        
        /*Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            //
        });*/

        return Land::find(1);

        Permission::truncate();
        Activity::truncate();
        ActivitySection::truncate();
        Land::truncate();

        Input::where('table','land')->delete();

        $inputs = ["Provincia",
        "Municipio",
        "HAS Totales",
        "Ref catastral",
        "Poligono y parcela",
        "Propiedad",
        "Teléfono ",
        "Mail",
        "Empresa Colaboradora",
        "Persona Contacto",
        "API/Propiedad",
        "Teléfono",
        "Mail",
        "Comentarios Iniciales",
        "MW nominales aval terreno",
        "Avales",
        "Has  Estimadas",
        "NIVEL TENSIÓN SET",
        "Capacidad Liberada SET",
        "TIPO",
        "Comentarios Técnicos",
        "Abogado Contrato",
        "Enviado Mail Condiciones",
        "€ Renta",
        "Prima"];

        foreach ($inputs as $key => $value) {
            $fr = new Input;
            $fr->table = 'land';
            $fr->type = 'text';
            $fr->title = $value;
            $fr->placeholder = $value;
            $fr->info = "";
            $fr->summary = 0;
            $fr->guarantee = 0;
            $fr->save();
        }

        return "";
        // Schema::create('administration_documents', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('administration_id')->nullable();
        //     $table->string('url')->nullable();
        //     $table->timestamps();
        // });

        // Schema::dropIfExists('administrations');
        // Schema::create('administrations', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->nullable();
        //     $table->string('dni')->nullable();
        //     $table->string('residence')->nullable();
        //     $table->string('position')->nullable();
        //     $table->string('date')->nullable();
        //     $table->timestamps();
        // });

        // return Land::count();
        /*Schema::dropIfExists('activities');
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_section_id')->nullable();
            $table->string('name')->nullable();
            $table->string('progress')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('responsable_benbros')->nullable();
            $table->string('responsable_external')->nullable();
            $table->string('administrative')->nullable();
            $table->text('commentary')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });*/

        /*Section::truncate();
        Input::truncate();
        InputOption::truncate();*/

        // return "OK";

        // $sections = [["name"=>"Acceso y Tramitación / Conexión de terrenos",
        //     "inputs" => [
        //         "Aval (Guarantee)",
        //         "Solicitud AyC",
        //         "Contrato terrenos",
        //         "Iniciación DUP"
        //     ]],
        //     ["name"=>"Declaración de Impacto Ambiental",
        //     "inputs" => [
        //         "Documento de alcance para EIA",
        //         "Obtención del documento de alcance para EIA",
        //         "Estudio de prefactibilidad",
        //         "Estudio arqueológico",
        //         "Estudio de avifauna",
        //         "Redacción EIA",
        //         "Resolución EIA"
        //     ]],
        //     ["name"=>"Proyecto Técnico",
        //     "inputs" => [
        //         "Estudio topográfico",
        //         "Estudios hidrológicos e hidraúlicos",
        //         "Redacción de proyecto de actuación",
        //         "Redacción proyecto de ejecución para AAP y AAC"
        //     ]],
        //     ["name"=>"Industria",
        //     "inputs" => [
        //         "Solicitud AAP",
        //         "Solicitud AAC",
        //         "Obtención AAP y AAC"
        //     ]],
        //     ["name"=>"Ayundamiento",
        //     "inputs" => [
        //         "Solicitud información urbanística",
        //         "Obtención de información urbanística",
        //         "Solicitud uso de suelo en SNU",
        //         "Obtención uso de suelo en SNU",
        //         "Solicitud licencia de obra",
        //         "Obtención licencia de obra"
        //     ]],
        //     ["name"=>"Tramitación de bienes y derechos afectados",
        //     "inputs" => [
        //         "Revisión de la Relación de Bienes y Derechos Afectados",
        //         "Gestión de permisos particulares. Mutuos acuerdos",
        //         "Gestión de actas de urgente ocupación",
        //         "Asistencia al levantamiento de actas de urgente ocupación",
        //         "Formalización de depósitos"
        //     ]],
        //     ["name"=>"Desarrollo socioeconómico",
        //     "inputs" => [

        //     ]]
        // ];

        $sections = 
        [["name"=>"Access & Connection", "inputs" => [
                "Aval (Guarantee)",
                "Solicitud AyC"
        ]],
        ["name"=>"Land permits", "inputs"=>
        [
            "Land contracts",
            "Field visit",
            "DUP"
        ]],
        ["name"=>"Environmental Impact Assesment", "inputs"=>
        [
            "EIA scoping document ",
            "Obtaining EIA scoping document",
            "Archeological study",
            "Birdlife study + fauna + alternatives",
            "Chiropteras study (with altenatives)",
            "EIA",
            "EIA Resolution"
        ]],

        ["name"=>"Technical Project", "inputs"=>
        [
            "Topographical study",
            "Hydrological study",
            "Layout",
            "Offprints",
            "Execution project for AAP and AAC"
        ]],

        ["name"=>"Ministry of Industry", "inputs"=>
        [
            "AAP request",
            "AAC request",
            "AAP and AAC resolution"
        ]],

        ["name"=>"Town Council", "inputs"=>
        [
            "Urban compatibility site",
            "Urban compatibility line ",
            "Building permit application (licencia de obras)",
            "Building permit resolution"
        ]],

        ["name"=>"RBDA permits", "inputs"=>
        [
            "RBDA permits",
            "Management of individual permits. Mutual agreements",
            "Management of emergency occupancy certificates",
            "Attendance at the lifting of emergency occupancy certificates",
            "Formalisation of deposits"
        ]],

        ["name"=>"Socio-economic criteria", "inputs"=>
        [
            "Financial model per Project",
            "Job creation and re-skilling ",
            "Reduction of electricity costs and promotion of self-consumption",
            "Business development "
        ]]];

        $options = ['Si','No','En progreso'];

        foreach ($sections as $key => $value) {
            
            $s = new Section;
            $s->name = $value['name'];
            $s->save();

            foreach ($value['inputs'] as $key => $value1) {

                $fr = new Input;
                $fr->section_id = $s->id;
                $fr->table = 'project';
                $fr->title = $value1;
                $fr->info = "";
                $fr->save();

                foreach ($options as $key => $value) {
                    $io = new InputOption;
                    $io->input_id = $fr->id;
                    $io->option = $value;
                    $io->save();
                }
            }

        }

        // $fields = [
        //     "Provincia",
        //     "Municipio",
        //     "HAS Totales",
        //     "Ref catastral",
        //     "Poligono y parcela",
        //     "Propiedad",
        //     "Teléfono ",
        //     "Mail",
        //     "Empresa Colaboradora",
        //     "Persona Contacto",
        //     "API/Propiedad",
        //     "Teléfono",
        //     "Mail",
        //     "Comentarios Iniciales",
        //     "MW nominales aval terreno",
        //     // "MWp estimados",
        //     // "MW nominales",
        //     "Avales",
        //     "HAS Estimadas",
        //     "SET",
        //     "NIVEL TENSIÓN SET",
        //     "Capacidad Liberada SET",
        //     "KM SET",
        //     "TIPO",
        //     "Comentarios Técnicos",
        //     "Abogado Contrato",
        //     "Enviado Mail Condiciones",
        //     "€ Renta",
        //     "Prima"
        // ];

        // foreach ($fields as $key => $value) {
        //     $fr = new Input;
        //     $fr->table = 'land';
        //     $fr->type = "text";
        //     $fr->title = $value;
        //     $fr->placeholder = "";
        //     $fr->info = "";
        //     $fr->summary = 0;
        //     $fr->save();
        // }


        // Schema::table('lands', function(Blueprint $table) {
        //     //
        //     $table->string('substation')->nullable();
        // });
        // Schema::table('lands', function(Blueprint $table) {
        //     //
        //     $table->string('substation_km')->nullable();
        // });
        // Schema::table('documents', function(Blueprint $table) {
        //     //
        //     $table->string('name')->nullable();
        // });
        // Schema::dropIfExists('permissions');
        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->nullable();
        //     $table->integer('land_id')->nullable();
        //     $table->string('tramitation_type')->nullable();
        //     $table->text('extra_inputs')->nullable();
        //     $table->integer('status')->nullable();
        //     $table->integer('order')->nullable();
        //     $table->timestamps();
        // });

        // Schema::table('lands', function(Blueprint $table) {
        //     //
        //     $table->dropColumn('tramitation_type');
        // });

        // Mail::send('test', [], function ($message) {
            
        //     $message->to('jorgesolano92@gmail.com', 'John Doe');
        
        //     $message->subject('Prueba');
        // });

        // Schema::table('inputs', function(Blueprint $table) {
        //     //
        //     $table->integer('guarantee')->nullable();
        // });

        return ActivityDocument::all();
    }

    public function getTemplate()
    {
        return view('modals.input-template')->render();
    }
    public function getTemplateEdit($id)
    {
        $inp = Input::find($id);
        return view('modals.edit-template',compact('inp'))->render();
    }

    public function saveInput(Request $r)
    {
        $this->validate($r,[
            'title'=>'required',
        ]);

        $fr = new Input;
        $fr->table = 'land';
        $fr->type = $r->type;
        $fr->title = $r->title;
        $fr->placeholder = $r->placeholder;
        $fr->info = $r->info;
        $fr->summary = $r->summary ? 1 : 0;
        $fr->guarantee = $r->guarantee ? 1 : 0;
        $fr->status = $r->status ? 1 : 0;
        $fr->save();

        /**/

        if (isset($r->options)) {
            foreach ($r->options as $key => $value) {
                $io = new InputOption;
                $io->input_id = $fr->id;
                $io->option = $value;
                $io->save();
            }
        }
    }

    public function editInput(Request $r)
    {
        $this->validate($r,[
            'title'=>'required',
        ]);

        $fr = Input::find($r->id);
        $fr->table = 'land';
        $fr->type = $r->type;
        $fr->title = $r->title;
        $fr->placeholder = $r->placeholder;
        $fr->info = $r->info;
        $fr->summary = $r->summary ? 1 : 0;
        $fr->guarantee = $r->guarantee ? 1 : 0;
        $fr->status = $r->status ? 1 : 0;
        $fr->save();

        InputOption::where('input_id',$fr->id)->delete();

        /**/

        if (isset($r->options)) {
            foreach ($r->options as $key => $value) {
                $io = new InputOption;
                $io->input_id = $fr->id;
                $io->option = $value;
                $io->save();
            }
        }
    }

    public function addLand()
    {
        $l = new Land;
        $l->save();

        return view('includes.lands')->render();
    }

    public function saveLand(Request $r)
    {
        $l = Land::find($r->id);
        $l->partner_id = $r->partner_id != 'null' ? $r->partner_id : $l->partner_id;
        $l->month = $r->month ? $r->month : $l->month;
        $l->week = $r->week ? $r->week : $l->week;
        $l->name = $r->name ? $r->name : $l->name;
        $l->analisys_state = $r->analisys_state != 'null' ? $r->analisys_state : $l->analisys_state;
        $l->contract_state = $r->contract_state != 'null' ? $r->contract_state : $l->contract_state;
        $l->negotiator = $r->negotiator ? $r->negotiator : $l->negotiator;
        $l->partner_info = $r->partner_info ? $r->partner_info : $l->partner_info;
        $l->becoming_date = $r->becoming_date ? $r->becoming_date : $l->becoming_date;
        $l->mwp = $r->mwp ? $r->mwp : $l->mwp;
        $l->mwn = $r->mwn ? $r->mwn : $l->mwn;
        $l->substation = $r->substation ? $r->substation : $l->substation;
        $l->substation_km = $r->substation_km ? $r->substation_km : $l->substation_km;
        
        if ($l->extra_inputs) {
            
            $extras = json_decode($l->extra_inputs,true);
            $editables = [];

            foreach ($extras as $key => $value) {
                foreach (json_decode($r->extras,true) as $key1 => $value1) {
                    if ($value['id'] == $value1['id']) {
                        $editables[] = ['id' => $key, 'value' => $value1['value']];
                    }
                }
            }
            foreach ($editables as $key => $value) {
                $extras[$value['id']]['value'] = $value['value'];
            }

            $l->extra_inputs = json_encode($extras);

        }else{
            $l->extra_inputs = $r->extras ? $r->extras : $l->extra_inputs;
        }


        $l->technology = $r->technology != 'null' ? $r->technology : $l->technology;
        $l->save();

        if ($l->analisys_state == 1 && $l->contract_state == 2) {

            $p = Permission::where('land_id',$l->id)->first();

            if (!$p) {
                $p = new Permission;
                $p->land_id = $l->id;
                $p->save();

                $this->generateActivities($p->id);
            }
        }
    }

    public function addStatus()
    {
        $l = new Status;
        $l->save();

        return view('includes.statuses')->render();
    }

    public function saveStatus(Request $r)
    {
        $l = Status::find($r->id);
        $l->type = $r->type;
        $l->name = $r->name;
        $l->save();
    }

    public function deleteStatus($id)
    {
        $l = Status::find($id)->delete();

        return back();
    }

    public function deleteLand($id)
    {
        $l = Land::find($id);
        $l->delete();

        return back();
    }
    public function deleteInput($id)
    {
        $l = Input::find($id);
        foreach ($l->options as $key => $value) {
            $value->delete();
        }
        $l->delete();

        return back();
    }

    public function addPartner()
    {
        $p = new Partner;
        $p->save();

        return view('includes.partners')->render();
    }
    public function deletePartner($id)
    {
        $p = Partner::find($id);
        $p->delete();

        return back();
    }

    public function savePartner(Request $r)
    {
        $p = Partner::find($r->id);
        $p->name = $r->name;
        $p->save();
    }

    public function saveDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/documents/',$name);

            $d = new Document;
            $d->document = $name;
            $d->name = $r->name;
            $d->type = $r->type;
            $d->order = 0;
            $d->save();

            return view('includes.documents',['type' => $r->type])->render();
        }
    }

    public function prepareKML($id)
    {
        $l = Land::find($id);

        function rrmdir($dir) { 
           if (is_dir($dir)) { 
             $objects = scandir($dir);
             foreach ($objects as $object) { 
               if ($object != "." && $object != "..") { 
                 if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                   rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                 else
                   unlink($dir. DIRECTORY_SEPARATOR .$object); 
               } 
             }
             rmdir($dir); 
           } 
         }

        rrmdir(public_path().'/temp/kml');

        mkdir(public_path().'/temp/kml');

        foreach(json_decode($l->extra_inputs,true) as $key => $value)
        {
            if ($value['id'] == 161) {

                $files = explode(',', $value['value']);
                $z = new ZipArchive;
                $n = Str::slug($l->name,'_').'.zip';

                @unlink(public_path().'/'.$n);

                $arrContextOptions=[
                    "ssl"=>[
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ],
                ];  

                if ($z->open(public_path().'/'.$n, ZipArchive::CREATE) === TRUE) {
                    foreach ($files as $key => $value1) {
                        if ($value1 != '') {


                            // $content = file_get_contents("http://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle.aspx?RefCat=".$value1);
                            $content = file_get_contents("https://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle3D.aspx?refcat=$value1&tipo=3d",false,stream_context_create($arrContextOptions));
                            // https://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle3D.aspx?refcat=&tipo=3d
                            // $content = file_get_contents("https://www1.sedecatastro.gob.es/Cartografia/FXCC/FXCC_KML.aspx?refcat=".$value1,false, stream_context_create($arrContextOptions));

                            $w = fopen(public_path().'/temp/kml/'.$value1.'.kml', "w");
                            fwrite($w,$content);
                            fclose($w);

                            // copy("http://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle.aspx?RefCat=".$value, public_path().'/temp/kml/'.$value.'.kml');
                            // return "https://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle.aspx?RefCat=".;
                            $z->addFile(public_path().'/temp/kml/'.$value1.'.kml',$value1.'.kml');
                        }
                    }
                    $z->close();
                }

                // if ($z->open(public_path().'/'.$n) === TRUE) {
                //     $z->deleteIndex(0);
                //     $z->close();
                // } 

                $p = public_path().'/'.$n;

                if (file_exists($p)) {
                    return url($n);
                }

                return response()->json('error',422);

            }
        }

        return response()->json("Error",422);

    }

    public function generateActivities($id)
    {
        $sections = [["name"=>"Land permits", "activities"=>
        [
            "Land contracts",
            "Field visit",
            "DUP"
        ]],

        ["name"=>"Environmental Impact Assesment", "activities"=>
        [
            "EIA scoping document ",
            "Obtaining EIA scoping document",
            "Archeological study",
            "Birdlife study + fauna + alternatives",
            "Chiropteras study (with altenatives)",
            "EIA",
            "EIA Resolution"
        ]],

        ["name"=>"Technical Project", "activities"=>
        [
            "Topographical study",
            "Hydrological study",
            "Layout",
            "Offprints",
            "Execution project for AAP and AAC"
        ]],

        ["name"=>"Ministry of Industry", "activities"=>
        [
            "AAP request",
            "AAC request",
            "AAP and AAC resolution"
        ]],

        ["name"=>"Town Council", "activities"=>
        [
            "Urban compatibility site",
            "Urban compatibility line ",
            "Building permit application (licencia de obras)",
            "Building permit resolution"
        ]],

        ["name"=>"RBDA permits", "activities"=>
        [
            "RBDA permits",
            "Management of individual permits. Mutual agreements",
            "Management of emergency occupancy certificates",
            "Attendance at the lifting of emergency occupancy certificates",
            "Formalisation of deposits"
        ]],

        ["name"=>"Socio-economic criteria", "activities"=>
        [
            "Financial model per Project",
            "Job creation and re-skilling ",
            "Reduction of electricity costs and promotion of self-consumption",
            "Business development "
        ]]];


        foreach ($sections as $key => $value) {
            
            $s = new ActivitySection;
            $s->permission_id = $id;
            $s->name = $value['name'];
            $s->save();

            foreach ($value['activities'] as $key => $value1) {
                $a = new Activity;
                $a->name = $value1;
                $a->activity_section_id = $s->id;
                $a->save();
            }
        }
    }

    public function saveLatLng(Request $r, $id)
    {
        $l = Land::find($id);
        $l->lat = $r->lat;
        $l->lng = $r->lng;
        $l->save();
    }

    public function findInformation(Request $r)
    {
        return Land::where('lat',$r->lat)->where('lng',$r->lng)->with('partner')->get()->groupBy('lat','lng');
    }

    public function addContact($id = null)
    {
        $c = new Contact;
        $c->contact_section_id = $id;
        $c->save();

        return view('includes.contacts', ['contact_section_id' => $id])->render();
    }

    public function addSection()
    {
        $c = new ContactSection;
        $c->save();

        $c->name = "Sección ".$c->id+1;
        $c->save();

        return redirect('contacts');
    }
    public function updateSection(Request $r)
    {
        $c = ContactSection::find($r->id);
        $c->name = $r->name;
        $c->save();
    }

    public function deleteSection($id)
    {
        $s = ContactSection::find($id);
        $c = Contact::where('contact_section_id',$id)->get();

        foreach ($c as $key => $value) {
             $value->contact_section_id = null;
             $value->save();
         } 
        $s->delete();

        return back();
    }
    public function deleteContact($id)
    {
        $c = Contact::find($id);
        $c->delete();

        return back();
    }
    public function saveContact(Request $r)
    {
        $c = Contact::find($r->id);
        $c->name = $r->name;
        $c->last_name = $r->last_name;
        $c->email = $r->email;
        $c->phone = $r->phone;
        $c->address = $r->address;
        $c->position = $r->position;
        $c->contact_section_id = $r->contact_section_id;
        $c->save();
    }

    public function saveAdministrative(Request $r)
    {
        $a = new Administration;
        $a->name = $r->name;
        $a->dni = $r->dni;
        $a->residence = $r->residence;
        $a->position = $r->position;
        $a->date = $r->date;
        $a->save();

        return redirect('/edit-administration/'.$a->id);
    }
    public function updateAdministrative(Request $r)
    {
        $a = Administration::find($r->id);
        $a->name = $r->name;
        $a->dni = $r->dni;
        $a->residence = $r->residence;
        $a->position = $r->position;
        $a->date = $r->date;
        $a->save();

        return redirect('/administration-organ');
    }

    public function saveAdministrationDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/administration-documents/',$name);

            $d = new AdministrationDocument;
            $d->administration_id = $r->id;
            $d->url = $name;
            $d->save();

            $a = Administration::find($r->id);

            return view('includes.administrative-documents',['a' => $a])->render();
        }
    }

    public function deleteAdministrativeDocument($id)
    {
        $a = AdministrationDocument::find($id);
        $a->delete();

        return back();
    }

    public function deleteAdministration($id)
    {
        $a = Administration::find($id);
        $a->delete();

        return back();
    }

    public function ContractDocuments()
    {
        return view('contract-documents');
    }

    public function saveContractDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/contract-documents/',$name);

            $d = new ContractDocument;
            $d->url = $name;
            $d->type = $r->type;
            $d->save();

            return view('includes.contract-documents', ['type' => $r->type])->render();
        }
    }

    public function deleteContractDocument($id)
    {
        $d = ContractDocument::find($id);
        $d->delete();

        return back();
    }


    /**/

    public function MaDocuments()
    {
        return view('ma-documents');
    }

    public function saveMaDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/ma-documents/',$name);

            $d = new MaDocument;
            $d->url = $name;
            $d->save();

            return view('includes.ma-documents')->render();
        }
    }

    public function deleteMaDocument($id)
    {
        $d = MaDocument::find($id);
        $d->delete();

        return back();
    }

    /**/

    public function OtherInformations()
    {
        return view('other-information');
    }

    public function saveOtherInformation(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/other-information/',$name);

            $d = new OtherInformation;
            $d->url = $name;
            $d->save();

            return view('includes.other-information')->render();
        }
    }

    public function deleteOtherInformation($id)
    {
        $d = MaDocument::find($id);
        $d->delete();

        return back();
    }

    /**/


    public function saveDataLand(Request $r)
    {
        $l = Land::find($r->id);
        $l->mwn = $r->mwn;
        $l->save();
    }

    public function addSubcontractor()
    {
        $p = new Subcontractor;
        $p->save();

        return view('includes.all-business')->render();
    }

    public function saveSubcontractor(Request $r)
    {
        $p = Subcontractor::find($r->id);
        $p->name = $r->name;
        $p->phone = $r->phone;
        $p->email = $r->email;
        $p->address = $r->address;
        $p->save();
    }

    public function deleteDocument($id)
    {
        $d = Document::find($id);
        $d->delete();

        return back();
    }

    public function ComplianceDocuments()
    {
        return view('compliance-documents');
    }
    public function saveComplianceDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/compliance-documents/',$name);

            $d = new ComplianceDocument;
            $d->url = $name;;
            $d->save();

            return view('includes.compliance-documents', ['type' => $r->type])->render();
        }
    }
    public function deleteComplianceDocument($id)
    {
        $d = ComplianceDocument::find($id);
        $d->delete();

        return back();
    }


    public function BudgetDocuments()
    {
        return view('budget-documents');
    }
    public function saveBudgetDocument(Request $r)
    {
        if ($r->hasFile('document')) {
            $file = $r->file('document');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/budget-documents/',$name);

            $d = new BudgetDocument;
            $d->url = $name;
            $d->save();

            return view('includes.budget-documents', ['type' => $r->type])->render();
        }
    }
    public function deleteBudgetDocument($id)
    {
        $d = BudgetDocument::find($id);
        $d->delete();

        return back();
    }

    public function saveTranslation(Request $r)
    {
        foreach ($r->column as $key => $value) {

            $t = Translate::where('lang',$r->lang)->where('table',$r->table)->where('column',$key)->where('ref_id',$r->ref_id)->first();
            if (!$t) {
                $t = new Translate;
            }
            $t->lang = $r->lang;
            $t->table = $r->table;
            $t->column = $key;
            $t->ref_id = $r->ref_id;
            $t->value = $value;
            $t->save();

        }
    }

    public function resetLocations()
    {
        $lands = Land::all();

        foreach ($lands as $key => $l) {
            $l->lat = null;
            $l->lng = null;
            $l->save();
        }

        return back()->with('msj',trans('layout.locations_reseted'));
    }

    public function uploadXML(Request $r)
    {
        $r->file->move(public_path().'/uploads/xml','config.xml');

        return url('uploads/xml/config.xml');
    }




    /**/


    public function technologies($id = null)
    {
        $tech = null;
        if ($id) {
            $tech = Technology::find($id);
        }
        $technologies = Technology::all();
        return view('technologies', compact('technologies','tech'));
    }
    public function saveTechnology(Request $r)
    {
        $tech = new Technology;

        if ($r->hasFile('icon')) {
            $name1 = 'icon_'.uniqid().'.png';
            $r->file('icon')->move(public_path().'/uploads/icon', $name1);
            $tech->icon = url('/uploads/icon/',$name1);
        }

        if ($r->hasFile('map_marker')) {
            $name2 = 'marker_'.uniqid().'.png';
            $r->file('map_marker')->move(public_path().'/uploads/map_marker', $name2);

            $tech->map_marker = url('/uploads/map_marker/',$name2);
        }

        $tech->name = $r->name;
        $tech->name_en = $r->name_en;
        $tech->report_color = $r->report_color;
        $tech->n_project = $r->n_project ? 1 : null;
        $tech->n_mwn = $r->n_mwn ? 1 : null;
        $tech->n_mwp = $r->n_mwp ? 1 : null;
        $tech->tenders = $r->tenders ? 1 : null;
        $tech->ac_req = $r->ac_req ? 1 : null;
        $tech->save();

        return back();
    }

    public function updateTechnology(Request $r)
    {
        $tech = Technology::find($r->id);

        if ($r->hasFile('icon')) {
            $name1 = 'icon_'.uniqid().'.png';
            $r->icon->move(public_path().'/uploads/icon', $name1);

            $tech->icon = url('/uploads/icon',$name1);
        }

        if ($r->hasFile('map_marker')) {
            $name2 = 'marker_'.uniqid().'.png';
            $r->map_marker->move(public_path().'/uploads/map_marker', $name2);

            $tech->map_marker = url('/uploads/map_marker',$name2);
        }

        $tech->name = $r->name;
        $tech->name_en = $r->name_en;
        $tech->report_color = $r->report_color;
        $tech->n_project = $r->n_project ? 1 : null;
        $tech->n_mwn = $r->n_mwn ? 1 : null;
        $tech->n_mwp = $r->n_mwp ? 1 : null;
        $tech->tenders = $r->tenders ? 1 : null;
        $tech->ac_req = $r->ac_req ? 1 : null;
        $tech->save();

        return back();
    }
    public function deleteTechnology($id)
    {
        $t = Technology::find($id);
        $t->delete();

        return back();
    }

    public function getTechnology($id)
    {
        $t = Technology::find($id);

        if (\App::getLocale() == 'es') {
            return $t->name;
        }

        return $t->name_en;
    }

}
