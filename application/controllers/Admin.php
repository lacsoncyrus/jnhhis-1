<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Admin extends CI_Controller{
    function __construct(){
      parent::__construct();
      $this->load->model('Model_admin');
      if($this->session->userdata("user_loggedin")==TRUE){
        if($this->session->userdata("type_id") == 5){
          redirect(base_url()."Radiology", "refresh");
        }
      }else{
        redirect(base_url());
      }
    }

    function index(){
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/index.php');
      $this->load->view('administrator/includes/footer.php');
    }
    /*=========================================================================================================================*/
    function PatientList($id = null){
      if(empty($id)){
        $data['patients'] = $this->Model_admin->get_patient_list();
        $data['total_patients_count'] = $this->Model_admin->get_total_patient_count();
        $this->load->view('administrator/includes/header.php');
        $this->load->view('administrator/patient/patientlist.php', $data);
        $this->load->view('administrator/includes/footer.php');
      }else{
        $data['patient'] = $this->Model_admin->get_single_patient($id);
        $data['total_patients_count'] = $this->Model_admin->get_total_patient_count();
        $this->load->view('administrator/includes/header.php');
        $this->load->view('administrator/patient/show_patient.php', $data);
        $this->load->view('administrator/includes/footer.php');
      }
    }

    function PatientHistory($id){
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patient/list_of_patient_history.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddPatient(){
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patient/addpatient.php');
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_patient(){
          $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('age', 'Age', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('birthday', 'Birthday', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('birthplace', 'Birthplace', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('occupation', 'Occupation', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('religion', 'Religion', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('telephone_number', 'Telephone number', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('mobile_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');

         if($this->form_validation->run() == FALSE){
           echo "may mali";
         }else{
           $data = array(
             'first_name' => $this->input->post('firstname'),
             'last_name' => $this->input->post('lastname'),
             'middle_name' => $this->input->post('middlename'),
             'gender' => $this->input->post('gender'),
             'age' => $this->input->post('age'),
             'birthdate' => $this->input->post('birthday'),
             'birthplace' => $this->input->post('birthplace'),
             'occupation' => $this->input->post('occupation'),
             'religion' => $this->input->post('religion'),
             'nationality' => $this->input->post('nationality'),
             'present_address' => $this->input->post('address'),
             'telephone_number' => $this->input->post('telephone_number'),
             'mobile_number' => $this->input->post('mobile_number'),
             'email' => $this->input->post('email'),
             'patient_status' => "0",
             'date_registered' => date('Y-m-d'),
           );

           $insertpatient = $this->Model_admin->insertpatient($data);
           $url = $this->input->post('url');
           if($url == base_url()."Admin/AddPatient"){
             redirect(base_url().'Admin/PatientList');
           }else{
             redirect(base_url()."Admin/AdmitER");
           }
         }
    }

    function EditPatient($id){
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patient/editpatient.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function edit_patient($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('age', 'Age', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Mobile', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'Birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthplace', 'Birthplace', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('occupation', 'Occupation', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('religion', 'Religion', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('telephone_number', 'Telephone', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      "last_name"=>$this->input->post('lastname'),
                      "first_name"=>$this->input->post('firstname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "age"=>$this->input->post('age'),
                      "nationality"=>$this->input->post('nationality'),
                      "mobile_number"=>$this->input->post('mobile_number'),
                      "birthdate"=>$this->input->post('birthday'),
                      "birthplace"=>$this->input->post('birthplace'),
                      "occupation"=>$this->input->post('occupation'),
                      "religion"=>$this->input->post('religion'),
                      "present_address"=>$this->input->post('address'),
                      "telephone_number"=>$this->input->post('telephone_number'),
                     );
        $this->Model_admin->edit_patient_information($data, $id);
        redirect(base_url().'Admin/PatientList/'.$id);
      }
    }

    function VitalSign($id){
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patient/view_vital.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function Pharmacy($id){
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patientlist/viewpharmacy.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function Billing($id){
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/patient/billinghistory.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    /*=========================================================================================================================*/

    function DoctorList(){
      $data['doctors'] = $this->Model_admin->get_doctor_list();
      $data['total_doctors_count'] = $this->Model_admin->get_total_doctor_count();
      $data['total_active_doctors_count'] = $this->Model_admin->get_total_active_doctor_count();
      $data['total_inactive_doctors_count'] = $this->Model_admin->get_total_inactive_doctor_count();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/doctor/active_doctorlist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function InactiveDoctor(){
      $data['doctors'] = $this->Model_admin->get_inactive_doctor_list();
      $data['total_doctors_count'] = $this->Model_admin->get_total_doctor_count();
      $data['total_active_doctors_count'] = $this->Model_admin->get_total_active_doctor_count();
      $data['total_inactive_doctors_count'] = $this->Model_admin->get_total_inactive_doctor_count();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/doctor/inactive_doctorlist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddDoctor(){
      $data['specialties'] = $this->Model_admin->get_specialty();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/doctor/adddoctor.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_doctor(){
      $this->form_validation->set_rules('specialty', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array("type_id"=>2,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("doctor"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        $this->Model_admin->insert_doctor_information($doctor_id, $this->input->post('specialty'));
        redirect(base_url().'Admin/DoctorList');
      }
    }

    function EditDoctor($id){
      $data['doctor'] = $this->Model_admin->get_single_doctor($id);
      $data['specialties'] = $this->Model_admin->get_specialty();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/doctor/editdoctor.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_doctor($id){
      $this->form_validation->set_rules('specialty', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         $this->Model_admin->update_doctor_information($id, $this->input->post('specialty'));
         redirect(base_url().'Admin/DoctorList');
      }
    }

    function ActivateDoctor($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveDoctor');
    }

    function DeactivateDoctor($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/DoctorList');
    }

    /*=========================================================================================================================*/
    function NurseList(){
      $data['nurses'] = $this->Model_admin->get_active_nurses_list();
      $data['total_nurse'] = $this->Model_admin->get_total_nurse();
      $data['total_active_nurse_manager'] = $this->Model_admin->get_total_active_nurse_manager();
      $data['total_inactive_nurse_manager'] = $this->Model_admin->get_total_inactive_nurse_manager();
      $data['total_active_bedside_nurse'] = $this->Model_admin->get_total_active_bedside_nurse();
      $data['total_inactive_bedside_nurse'] = $this->Model_admin->get_total_inactive_bedside_nurse();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/nurse/active_nurselist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function InactiveNurse(){
      $data['nurses'] = $this->Model_admin->get_inactive_nurses_list();
      $data['total_nurse'] = $this->Model_admin->get_total_nurse();
      $data['total_active_nurse_manager'] = $this->Model_admin->get_total_active_nurse_manager();
      $data['total_inactive_nurse_manager'] = $this->Model_admin->get_total_inactive_nurse_manager();
      $data['total_active_bedside_nurse'] = $this->Model_admin->get_total_active_bedside_nurse();
      $data['total_inactive_bedside_nurse'] = $this->Model_admin->get_total_inactive_bedside_nurse();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/nurse/inactive_nurselist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddNurse(){
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/nurse/addnurse.php');
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_nurse(){
      $this->form_validation->set_rules('nursetype', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo "may mali";
      }else{
        $data = array("type_id"=>$this->input->post('nursetype'),
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("nurse"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/NurseList');
      }
    }

    function EditNurse($id){
      $data['nurse'] = $this->Model_admin->get_single_nurse($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/nurse/editnurse.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_nurse($id){
      $this->form_validation->set_rules('nursetype', 'Position', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number'),
                      'type_id'=>$this->input->post('nursetype')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/NurseList');
      }
    }

    function ActivateNurse($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveNurse');
    }

    function DeactivateNurse($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/NurseList');
    }

    /*=========================================================================================================================*/

    function RadiologistList(){
      $data['radiologists'] = $this->Model_admin->get_active_radiologists();
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/radiology/active_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function InactiveRadiologist(){
      $data['radiologists'] = $this->Model_admin->get_inactive_radiologists();
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/radiology/inactive_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddRadiologist(){
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/radiology/add_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_radiologist(){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo "may mali";
      }else{
        $data = array("type_id"=>5,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("radiologist"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/RadiologistList');
      }
    }

    function EditRadioligst($id){
      $data['radiologist'] = $this->Model_admin->get_single_radiologist($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/radiology/edit_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_radiologist($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/RadiologistList');
      }
    }

    function ActivateRadiologist($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveRadiologist');
    }

    function DeactivateRadiologist($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/RadiologistList');
    }

    /*=========================================================================================================================*/
    function PharmacistList(){
      $data['pharmacists'] = $this->Model_admin->get_active_pharmacist();
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/pharmacy/active_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function InactivePharmacist(){
      $data['pharmacists'] = $this->Model_admin->get_inactive_pharmacist();
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/pharmacy/inactive_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddPharmacist(){
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/pharmacy/add_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_pharmacist(){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array("type_id"=>6,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("pharmacist"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/PharmacistList');
      }
    }

    function EditPharmacist($id){
      $data['pharmacist'] = $this->Model_admin->get_single_pharmacist($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/pharmacy/edit_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_pharmacist($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/PharmacistList');
      }
    }


    function ActivatePharmacist($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactivePharmacist');
    }

    function DeactivatePharmacist($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/PharmacistList');
    }
    /*=========================================================================================================================*/
    function EmergencyRoom(){
      $data['emergency_rooms'] = $this->Model_admin->get_beds_from_emergency_room();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/admitting/choose_er_room.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function ChoosePatient($bed_id){
      $data['patients'] = $this->Model_admin->get_non_admitted_patient_list();
      $data['bed_id'] = $bed_id;
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/admitting/choosepatient_to_er.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }


    function InsertAdmitFromER($bed_id){
      $patient = $this->input->post('patient');
      $data_bedstable = array(
                    "bed_patient"=>$patient
                  );
      $data_admission_schedule = array(
                                        "admission_date"=>date('Y-m-d H:i:s'),
                                        "patient_id"=>$patient,
                                        "status"=>1
                                       );
      $data_admitting_resident = array(
                                        "user_id"=>$this->session->userdata("user_id"),
                                        "patient_id"=>$patient
                                      );
     $data_update_patient_status = array(
                                          "patient_status"=>1
                                        );
     $this->Model_admin->insert_patient_to_beds($data_bedstable, $bed_id);
     $this->Model_admin->insert_admission_schedule($data_admission_schedule);
     $this->Model_admin->insert_admitting_resident($data_admitting_resident);
     $this->Model_admin->update_patient_status($data_update_patient_status, $patient);
     redirect(base_url().'Admin/EmergencyRoom', 'refresh');
    }

    function DischargePatient($patient_id, $bed_id){
      $data_discharge = array("status"=>2);
      $data_update_bed = array();
      $this->Model_admin->dischargepatient($data, $patient_id);
      redirect(base_url()."Admin/EmergencyRoom");
    }
    /*=========================================================================================================================*/
    function RoomType()
    {
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/rooms/roomtypelist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_roomtype(){
      $this->form_validation->set_rules('roomname', 'Room Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomprice', 'Room Price', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomdesc', 'Room Description', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_name' => $this->input->post('roomname'),
                      'room_description' => $this->input->post('roomdesc'),
                      'room_price' => $this->input->post('roomprice')
                     );
        $insertroomtype = $this->Model_admin->insertroomtype($data);
        redirect(base_url()."Admin/RoomType");
      }
    }

    function UpdateRoomType($id){
      $data['roomtype'] = $this->Model_admin->get_room_type($id);
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/rooms/updateroomtype.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_roomtype($id){
      $this->form_validation->set_rules('roomname', 'Room Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomprice', 'Room Price', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomdesc', 'Room Description', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_name' => $this->input->post('roomname'),
                      'room_description' => $this->input->post('roomdesc'),
                      'room_price' => $this->input->post('roomprice')
                     );
        $this->Model_admin->updateroomtype($data, $id);
        redirect(base_url()."Admin/RoomType");
      }
    }

    function Rooms(){
      $data['rooms'] = $this->Model_admin->get_room_list();
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/rooms/roomlist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_room(){
      $this->form_validation->set_rules('roomtype', 'Room Type', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomloc', 'Room Location', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_type' => $this->input->post('roomtype'),
                      'room_location' => $this->input->post('roomloc'),
                      'occupancy_status' => 1,
                      'maintenance_status' => 1
                    );

        $insertroomtype = $this->Model_admin->insertroom($data);
        $beddata = array(
                        'bed_roomid' => $insertroomtype
                        );
        $bednum = $this->input->post('bednum');
        for($i=1;$i<=$bednum;$i++)
        {
            $this->Model_admin->insertbedsinroom($beddata);
        }

        redirect(base_url()."Admin/Rooms");
      }
    }

    function ViewRoom($id){
      $data['roomdata'] = $this->Model_admin->get_room_data($id);
      $data['roomid'] = $id;
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/rooms/viewroom.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function UpdateRoom($id){
      $data['rooms'] = $this->Model_admin->get_single_room_type($id);
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php');
      $this->load->view('administrator/rooms/updateroom.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_room($id){
      $this->form_validation->set_rules('roomtype', 'Room Type', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomloc', 'Room Location', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_type' => $this->input->post('roomtype'),
                      'room_location' => $this->input->post('roomloc')
                     );
        $this->Model_admin->updateroom($data, $id);
        redirect(base_url()."Admin/Rooms");
      }
    }

     function add_bed($id){
      $beddata = array(
                      'bed_roomid' => $id
                      );
      $bednum = $this->input->post('bednum');
      for($i=1;$i<=$bednum;$i++)
      {
          $this->Model_admin->insertbedsinroom($beddata);
      }
      redirect(base_url()."Admin/ViewRoom/".$id);
    }

    function remove_bed($roomid, $id){
      $this->Model_admin->removebed($id);
      redirect(base_url()."Admin/ViewRoom/".$roomid);
    }
    /*=========================================================================================================================*/
    function LaboratoryRequests(){
  $this->load->view('administrator/includes/header.php');
  $this->load->view('administrator/laboratory/laboratoryrequest.php');
  $this->load->view('administrator/includes/footer.php');
}
    /*=========================================================================================================================*/
    function logout(){
      $this->session->sess_destroy();
      redirect(base_url());
    }
  }
?>
