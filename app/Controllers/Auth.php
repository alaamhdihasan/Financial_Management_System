<?php  namespace App\Controllers;
use App\Libraries\Hash;
use Config\App;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['url','form']);
    }
    public function index()
    {

        return view('auth/login');
        
        
    }
    
    public function create(){

        return view('auth/registers');
    }

    public function save(){

        // $validation=$this->validate([
        //     'name'=>'required',
        //     'email'=>'required|valid_email|is_unique[tb_users.user_Email]',
        //     'password'=>'required|min_length[5]|max_length[5]',
        //     'cpassword'=> 'required|min_length[5]|max_length[5]|matches[password]',
        //     'department'=>'required'
        // ]);

            $validation=$this->validate([
                'name'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'اسم المستخدم مطلوب '
                    ]
                    ],
                'email'=>[
                    'rules'=> 'required|valid_email|is_unique[tb_users.user_Email]',
                    'errors'=>[
                        'required'=>'يرجى ادخال البريد الالكتروني',
                        'valid_email'=>'خطأ في صيغة البريد الالكتروني',
                        'is_unique[tb_users.user_Email]'=>'هذا البريد مسجلاً مسبقاً'
                    ]
                    ],
                'password'=>[
                    'rules'=> 'required|min_length[5]|max_length[15]',
                    'errors'=>[
                            'required'=>'يرجى ادخال الباسورد',
                            'min_length'=>'يجب ان يحتوي الباسورد على الاقل على 5 احرف او ارقام',
                            'max_length'=>' يجب ان يحتوي الباسورد على الاكثر 15 حرف او ارقم او رمز'
                        ]
                        ],
                'cpassword'=>[
                    'rules'=> 'required|min_length[5]|max_length[15]|matches[password]',
                    'errors'=>[
                             'required'=>'يجب تأكيد كلمة الباسورد',
                             'min_length'=> 'يجب ان يحتوي الباسورد على الاقل على 5 احرف او ارقام',
                             'max_length'=> 'يجب ان يحتوي الباسورد على الاكثر 15 حرف او ارقم او رمز',
                             'matches'=>'كلمة الباسورد غير متطابقة'
                         ]

                    ],
            ]);



        if(!$validation){
            return view('auth/registers',['validation'=>$this->validator]);
        }
        else{
            $name=$this->request->getPost('name');
            $password=$this->request->getPost('password');
            $email=$this->request->getPost('email');
            $department=$this->request->getPost('department');

            $values=[
                'user_Name'=>$name,
                'user_Password'=>Hash::make($password),
                'user_Email'=>$email,
                'user_Type'=>'عادي'
            ];

            $usermodel= new \App\Models\Users_M();
            $query=$usermodel->insert($values);

            if(!$query){
                return redirect()->to(base_url('auth/registers'))->with('fail','حدث خطأ في عملية ادخال البيانات');
            }else{
               // return redirect()->to(base_url('auth/registers'))->with('status', 'تمت عملية  التسجيل بنجاح');
                $last_id=$usermodel->insertID();
                session()->set('loggedUser',$last_id);
                return redirect()->to(base_url('home'));

            }

        }
    }

    public function check(){

        $validation=$this->validate([
            'u_username'=>[
                'rules'=>'required|is_not_unique[tb_Users.U_UserName]',
                'errors'=>[
                    'required'=>'يجب ادخال  اسم المستخدم',  
                    'is_not_unique'=>'هذا المستخدم غير مسجل في النظام'
                ]
            ],
            'u_password' => [
                'rules' => 'required|min_length[5]|max_length[15]',
                'errors' => [
                    'required' => 'يرجى ادخال كلمة المرور',
                    'min_length' => 'يجب ان تحتوي كلمة المرور على الاقل على 5 احرف او ارقام',
                    'max_length' => ' يجب ان تحتوي كلمة المرور على الاكثر 15 حرف او ارقم او رمز'
                ]
            ],
         ]);

         if(!$validation){
            return view('auth/login',['validation'=>$this->validator]);
            //return redirect()->to(base_url('auth/login'))->with('status', 'فشل عملية الدخول');
         }else{

            $u_username=$this->request->getPost('u_username');
            $u_password = $this->request->getPost('u_password');
            $usermodel= new \App\Models\Users_M();
            $userinfo=$usermodel->where('U_UserName',$u_username)->first();
            $check_password=Hash::check($u_password, $userinfo['U_Password']);

            if(!$check_password){
                session()->setFlashdata('status','كلمة المرور خطأ');
                return redirect()->to(base_url('auth'))->withInput();

            }
            else{
                $user_id=$userinfo['U_ID'];
                session()->set('loggedUser',$user_id);
               //$data['title']="Dashboard";

               //return view('admin/dashboard',$data);
               return redirect()->to(base_url('admins'));
            }
  
         }
        
    }

    function logout()
    {
        if (session()->has('loggedUser')) {
            session()->remove('loggedUser');
            return redirect()->to(base_url('auth'))->with('status', 'لقد تم تسجيل الخروج من النظام');
        }
    }
       
}