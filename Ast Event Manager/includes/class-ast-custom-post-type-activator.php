<?php

/**
 * Fired during plugin activation
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */



	public function activate() {
    
        $this->ast_check_woocommerce_activate();
        $this->ast_init_db_custom_table();
        $this->ast_creating_new_page_for_registration();
        // $this->all_countries();
        // $this->all_indiamap();
        $this->ast_currency();
  }

  // Initialize DB Tables
  public function ast_init_db_custom_table() {

    global $wpdb;

    $db_event_table = $wpdb->prefix . 'events_data';  // table name
    if ($wpdb->get_var("SHOW table like '".$db_event_table."'") != $db_event_table) {

        $table_events = "CREATE TABLE `".$db_event_table."` (
                      `ID` int(11) NOT NULL AUTO_INCREMENT,
                      `name` varchar(150) NOT NULL,
                      `mobile` varchar(150) NOT NULL,
                      `email` varchar(200) NOT NULL,
                      `event_id` int(150) NOT NULL,
                      `uid` int(11) NULL,
                      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                      PRIMARY KEY (`ID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"; //table create query
        
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($table_events);        
    } 

    $db_currency_table = $wpdb->prefix . 'currency';  // table name
    if ($wpdb->get_var("SHOW table like '".$db_currency_table."'") != $db_currency_table) {

        $table_currency = "CREATE TABLE `".$db_currency_table."` (
                      `ID` int(11) NOT NULL AUTO_INCREMENT,
                      `countrycode` varchar(100) NOT NULL,
                      `countryname` varchar(255) NOT NULL,
                      `currencyname` varchar(100) NOT NULL,
                      `symbol` varchar(100) NOT NULL,
                      PRIMARY KEY (`ID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"; //table create query
        
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($table_currency);        
    }

    $tablelist = array(
      'book_event_table' => $db_event_table,
      'ast_event_currency' => $db_currency_table,
    );
    update_option('ast_table_name', $tablelist);

  }


  public function ast_creating_new_page_for_registration(){
    global $wpdb;
    $user_id = get_current_user_id();
    $page_definitions = array(
        'ast-event-register' => array(
            "post_title" => "Event Register",
            'post_name' => "event-register",
            'post_status'  => "publish",   
            'post_author'  => $user_id,   
            'post_content'  => '[ast-event-booked-form]',          
            'post_type'  => "page"  
        ),
        'ast-event-profile' => array(
            "post_title" => "Event Profile",
            'post_name' => "event-profile",
            'post_status'  => "publish",   
            'post_author'  => $user_id,   
            'post_content'  => '[ast-event-prifile]',          
            'post_type'  => "page"  
        ),
    );
        
    
    $pageid = array();
    foreach ( $page_definitions as $slug => $page ) {


        //Check that the page doesn't exist already
        $query = new WP_Query( 'pagename=' . $slug );
        if (  !$query->have_posts() ) {
            //Add the page using the data from the array above
            $pageid[$slug] = wp_insert_post(array(
                    'post_content'   => $page['post_content'],
                    'post_name'      => $slug,
                    'post_title'     => $page['post_title'],
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'ping_status'    => 'closed',
                    'comment_status' => 'closed',
                ), true
            );
            
        }
    }

    update_option( 'ast_event_registration_page_id', $pageid ); 
  }


  public function all_countries(){

      $countries = array(
        "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"
      );

      foreach ($countries as $y)
      {
          // echo "<strong>".$y."</strong><br>";
          $post_state = wp_insert_post(array (
              'post_type' => 'country',
              'post_title' => $y,
              'post_status' => 'publish',
              'comment_status' => 'closed',   // if you prefer
              'ping_status' => 'closed',      // if you prefer
          ));    

                
         
      } 

  }


  public function all_indiamap(){

      $india = 
          array (
            'Andaman and Nicobar Island' => 
            array (
              1 => 'Nicobar',
              2 => 'North and Middle Andaman',
              3 => 'South Andaman',
            ),
            'Andhra Pradesh' => 
            array (
              1 => 'Anantapur',
              2 => 'Chittoor',
              3 => 'East Godavari',
              4 => 'Guntur',
              5 => 'Krishna',
              6 => 'Kurnool',
              7 => 'Prakasam',
              8 => 'Srikakulam',
              9 => 'Sri Potti Sriramulu Nellore',
              10 => 'Visakhapatnam',
              11 => 'Vizianagaram',
              12 => 'West Godavari',
              13 => 'YSR District, Kadapa (Cuddapah)',
            ),
            'Arunachal Pradesh' => 
            array (
              1 => 'Anjaw',
              2 => 'Changlang',
              3 => 'Dibang Valley',
              4 => 'East Kameng',
              5 => 'East Siang',
              6 => 'Kra Daadi',
              7 => 'Kurung Kumey',
              8 => 'Lohit',
              9 => 'Longding',
              10 => 'Lower Dibang Valley',
              11 => 'Lower Siang',
              12 => 'Lower Subansiri',
              13 => 'Namsai',
              14 => 'Papum Pare',
              15 => 'Siang',
              16 => 'Tawang',
              17 => 'Tirap',
              18 => 'Upper Siang',
              19 => 'Upper Subansiri',
              20 => 'West Kameng',
              21 => 'West Siang',
            ),
            'Assam' => 
            array (
              1 => 'Baksa',
              2 => 'Barpeta',
              3 => 'Biswanath',
              4 => 'Bongaigaon',
              5 => 'Cachar',
              6 => 'Charaideo',
              7 => 'Chirang',
              8 => 'Darrang',
              9 => 'Dhemaji',
              10 => 'Dhubri',
              11 => 'Dibrugarh',
              12 => 'Dima Hasao (North Cachar Hills)',
              13 => 'Goalpara',
              14 => 'Golaghat',
              15 => 'Hailakandi',
              16 => 'Hojai',
              17 => 'Jorhat',
              18 => 'Kamrup',
              19 => 'Kamrup Metropolitan',
              20 => 'Karbi Anglong',
              21 => 'Karimganj',
              22 => 'Kokrajhar',
              23 => 'Lakhimpur',
              24 => 'Majuli',
              25 => 'Morigaon',
              26 => 'Nagaon',
              27 => 'Nalbari',
              28 => 'Sivasagar',
              29 => 'Sonitpur',
              30 => 'South Salamara-Mankachar',
              31 => 'Tinsukia',
              32 => 'Udalguri',
              33 => 'West Karbi Anglong',
            ),
            'Bihar' => 
            array (
              1 => 'Araria',
              2 => 'Arwal',
              3 => 'Aurangabad',
              4 => 'Banka',
              5 => 'Begusarai',
              6 => 'Bhagalpur',
              7 => 'Bhojpur',
              8 => 'Buxar',
              9 => 'Darbhanga',
              10 => 'East Champaran (Motihari)',
              11 => 'Gaya',
              12 => 'Gopalganj',
              13 => 'Jamui',
              14 => 'Jehanabad',
              15 => 'Kaimur (Bhabua)',
              16 => 'Katihar',
              17 => 'Khagaria',
              18 => 'Kishanganj',
              19 => 'Lakhisarai',
              20 => 'Madhepura',
              21 => 'Madhubani',
              22 => 'Munger (Monghyr)',
              23 => 'Muzaffarpur',
              24 => 'Nalanda',
              25 => 'Nawada',
              26 => 'Patna',
              27 => 'Purnia (Purnea)',
              28 => 'Rohtas',
              29 => 'Saharsa',
              30 => 'Samastipur',
              31 => 'Saran',
              32 => 'Sheikhpura',
              33 => 'Sheohar',
              34 => 'Sitamarhi',
              35 => 'Siwan',
              36 => 'Supaul',
              37 => 'Vaishali',
              38 => 'West Champaran',
            ),
            'Chandigarh' => 
            array (
              1 => 'Chandigarh',
            ),
            'Chhattisgarh' => 
            array (
              1 => 'Balod',
              2 => 'Baloda Bazar',
              3 => 'Balrampur',
              4 => 'Bastar',
              5 => 'Bemetara',
              6 => 'Bijapur',
              7 => 'Bilaspur',
              8 => 'Dantewada (South Bastar)',
              9 => 'Dhamtari',
              10 => 'Durg',
              11 => 'Gariyaband',
              12 => 'Janjgir-Champa',
              13 => 'Jashpur',
              14 => 'Kabirdham (Kawardha)',
              15 => 'Kanker (North Bastar)',
              16 => 'Kondagaon',
              17 => 'Korba',
              18 => 'Korea (Koriya)',
              19 => 'Mahasamund',
              20 => 'Mungeli',
              21 => 'Narayanpur',
              22 => 'Raigarh',
              23 => 'Raipur',
              24 => 'Rajnandgaon',
              25 => 'Sukma',
              26 => 'Surajpur  ',
              27 => 'Surguja',
            ),
            'Dadra and Nagar Haveli' => 
            array (
              1 => 'Dadra & Nagar Haveli',
            ),
            'Daman and Diu' => 
            array (
              1 => 'Daman',
              2 => 'Diu',
            ),
            'Delhi' => 
            array (
              1 => 'Central Delhi',
              2 => 'East Delhi',
              3 => 'New Delhi',
              4 => 'North Delhi',
              5 => 'North East  Delhi',
              6 => 'North West  Delhi',
              7 => 'Shahdara',
              8 => 'South Delhi',
              9 => 'South East Delhi',
              10 => 'South West  Delhi',
              11 => 'West Delhi',
            ),
            'Goa' => 
            array (
              1 => 'North Goa',
              2 => 'South Goa',
            ),
            'Gujarat' => 
            array (
              1 => 'Ahmedabad',
              2 => 'Amreli',
              3 => 'Anand',
              4 => 'Aravalli',
              5 => 'Banaskantha (Palanpur)',
              6 => 'Bharuch',
              7 => 'Bhavnagar',
              8 => 'Botad',
              9 => 'Chhota Udepur',
              10 => 'Dahod',
              11 => 'Dangs (Ahwa)',
              12 => 'Devbhoomi Dwarka',
              13 => 'Gandhinagar',
              14 => 'Gir Somnath',
              15 => 'Jamnagar',
              16 => 'Junagadh',
              17 => 'Kachchh',
              18 => 'Kheda (Nadiad)',
              19 => 'Mahisagar',
              20 => 'Mehsana',
              21 => 'Morbi',
              22 => 'Narmada (Rajpipla)',
              23 => 'Navsari',
              24 => 'Panchmahal (Godhra)',
              25 => 'Patan',
              26 => 'Porbandar',
              27 => 'Rajkot',
              28 => 'Sabarkantha (Himmatnagar)',
              29 => 'Surat',
              30 => 'Surendranagar',
              31 => 'Tapi (Vyara)',
              32 => 'Vadodara',
              33 => 'Valsad',
            ),
            'Haryana' => 
            array (
              1 => 'Ambala',
              2 => 'Bhiwani',
              3 => 'Charkhi Dadri',
              4 => 'Faridabad',
              5 => 'Fatehabad',
              6 => 'Gurgaon',
              7 => 'Hisar',
              8 => 'Jhajjar',
              9 => 'Jind',
              10 => 'Kaithal',
              11 => 'Karnal',
              12 => 'Kurukshetra',
              13 => 'Mahendragarh',
              14 => 'Mewat',
              15 => 'Palwal',
              16 => 'Panchkula',
              17 => 'Panipat',
              18 => 'Rewari',
              19 => 'Rohtak',
              20 => 'Sirsa',
              21 => 'Sonipat',
              22 => 'Yamunanagar',
            ),
            'Himachal Pradesh' => 
            array (
              1 => 'Bilaspur',
              2 => 'Chamba',
              3 => 'Hamirpur',
              4 => 'Kangra',
              5 => 'Kinnaur',
              6 => 'Kullu',
              7 => 'Lahaul & Spiti',
              8 => 'Mandi',
              9 => 'Shimla',
              10 => 'Sirmaur (Sirmour)',
              11 => 'Solan',
              12 => 'Una',
            ),
            'Jammu and Kashmir' => 
            array (
              1 => 'Anantnag',
              2 => 'Bandipore',
              3 => 'Baramulla',
              4 => 'Budgam',
              5 => 'Doda',
              6 => 'Ganderbal',
              7 => 'Jammu',
              8 => 'Kargil',
              9 => 'Kathua',
              10 => 'Kishtwar',
              11 => 'Kulgam',
              12 => 'Kupwara',
              13 => 'Leh',
              14 => 'Poonch',
              15 => 'Pulwama',
              16 => 'Rajouri',
              17 => 'Ramban',
              18 => 'Reasi',
              19 => 'Samba',
              20 => 'Shopian',
              21 => 'Srinagar',
              22 => 'Udhampur',
            ),
            'Jharkhand' => 
            array (
              1 => 'Bokaro',
              2 => 'Chatra',
              3 => 'Deoghar',
              4 => 'Dhanbad',
              5 => 'Dumka',
              6 => 'East Singhbhum',
              7 => 'Garhwa',
              8 => 'Giridih',
              9 => 'Godda',
              10 => 'Gumla',
              11 => 'Hazaribag',
              12 => 'Jamtara',
              13 => 'Khunti',
              14 => 'Koderma',
              15 => 'Latehar',
              16 => 'Lohardaga',
              17 => 'Pakur',
              18 => 'Palamu',
              19 => 'Ramgarh',
              20 => 'Ranchi',
              21 => 'Sahibganj',
              22 => 'Seraikela-Kharsawan',
              23 => 'Simdega',
              24 => 'West Singhbhum',
            ),
            'Karnataka' => 
            array (
              1 => 'Bagalkot',
              2 => 'Ballari (Bellary)',
              3 => 'Belagavi (Belgaum)',
              4 => 'Bengaluru (Bangalore) Rural',
              5 => 'Bengaluru (Bangalore) Urban',
              6 => 'Bidar',
              7 => 'Chamarajanagar',
              8 => 'Chikballapur',
              9 => 'Chikkamagaluru (Chikmagalur)',
              10 => 'Chitradurga',
              11 => 'Dakshina Kannada',
              12 => 'Davangere',
              13 => 'Dharwad',
              14 => 'Gadag',
              15 => 'Hassan',
              16 => 'Haveri',
              17 => 'Kalaburagi (Gulbarga)',
              18 => 'Kodagu',
              19 => 'Kolar',
              20 => 'Koppal',
              21 => 'Mandya',
              22 => 'Mysuru (Mysore)',
              23 => 'Raichur',
              24 => 'Ramanagara',
              25 => 'Shivamogga (Shimoga)',
              26 => 'Tumakuru (Tumkur)',
              27 => 'Udupi',
              28 => 'Uttara Kannada (Karwar)',
              29 => 'Vijayapura (Bijapur)',
              30 => 'Yadgir',
            ),
            'Kerala' => 
            array (
              1 => 'Alappuzha',
              2 => 'Ernakulam',
              3 => 'Idukki',
              4 => 'Kannur',
              5 => 'Kasaragod',
              6 => 'Kollam',
              7 => 'Kottayam',
              8 => 'Kozhikode',
              9 => 'Malappuram',
              10 => 'Palakkad',
              11 => 'Pathanamthitta',
              12 => 'Thiruvananthapuram',
              13 => 'Thrissur',
              14 => 'Wayanad',
            ),
            'Lakshadweep' => 
            array (
              1 => 'Lakshadweep',
            ),
            'Madhya Pradesh' => 
            array (
              1 => 'Agar Malwa',
              2 => 'Alirajpur',
              3 => 'Anuppur',
              4 => 'Ashoknagar',
              5 => 'Balaghat',
              6 => 'Barwani',
              7 => 'Betul',
              8 => 'Bhind',
              9 => 'Bhopal',
              10 => 'Burhanpur',
              11 => 'Chhatarpur',
              12 => 'Chhindwara',
              13 => 'Damoh',
              14 => 'Datia',
              15 => 'Dewas',
              16 => 'Dhar',
              17 => 'Dindori',
              18 => 'Guna',
              19 => 'Gwalior',
              20 => 'Harda',
              21 => 'Hoshangabad',
              22 => 'Indore',
              23 => 'Jabalpur',
              24 => 'Jhabua',
              25 => 'Katni',
              26 => 'Khandwa',
              27 => 'Khargone',
              28 => 'Mandla',
              29 => 'Mandsaur',
              30 => 'Morena',
              31 => 'Narsinghpur',
              32 => 'Neemuch',
              33 => 'Panna',
              34 => 'Raisen',
              35 => 'Rajgarh',
              36 => 'Ratlam',
              37 => 'Rewa',
              38 => 'Sagar',
              39 => 'Satna',
              40 => 'Sehore',
              41 => 'Seoni',
              42 => 'Shahdol',
              43 => 'Shajapur',
              44 => 'Sheopur',
              45 => 'Shivpuri',
              46 => 'Sidhi',
              47 => 'Singrauli',
              48 => 'Tikamgarh',
              49 => 'Ujjain',
              50 => 'Umaria',
              51 => 'Vidisha',
            ),
            'Maharashtra' => 
            array (
              1 => 'Ahmednagar',
              2 => 'Akola',
              3 => 'Amravati',
              4 => 'Aurangabad',
              5 => 'Beed',
              6 => 'Bhandara',
              7 => 'Buldhana',
              8 => 'Chandrapur',
              9 => 'Dhule',
              10 => 'Gadchiroli',
              11 => 'Gondia',
              12 => 'Hingoli',
              13 => 'Jalgaon',
              14 => 'Jalna',
              15 => 'Kolhapur',
              16 => 'Latur',
              17 => 'Mumbai City',
              18 => 'Mumbai Suburban',
              19 => 'Nagpur',
              20 => 'Nanded',
              21 => 'Nandurbar',
              22 => 'Nashik',
              23 => 'Osmanabad',
              24 => 'Palghar',
              25 => 'Parbhani',
              26 => 'Pune',
              27 => 'Raigad',
              28 => 'Ratnagiri',
              29 => 'Sangli',
              30 => 'Satara',
              31 => 'Sindhudurg',
              32 => 'Solapur',
              33 => 'Thane',
              34 => 'Wardha',
              35 => 'Washim',
              36 => 'Yavatmal',
            ),
            'Manipur' => 
            array (
              1 => 'Bishnupur',
              2 => 'Chandel',
              3 => 'Churachandpur',
              4 => 'Imphal East',
              5 => 'Imphal West',
              6 => 'Jiribam',
              7 => 'Kakching',
              8 => 'Kamjong',
              9 => 'Kangpokpi',
              10 => 'Noney',
              11 => 'Pherzawl',
              12 => 'Senapati',
              13 => 'Tamenglong',
              14 => 'Tengnoupal',
              15 => 'Thoubal',
              16 => 'Ukhrul',
            ),
            'Meghalaya' => 
            array (
              1 => 'East Garo Hills',
              2 => 'East Jaintia Hills',
              3 => 'East Khasi Hills',
              4 => 'North Garo Hills',
              5 => 'Ri Bhoi',
              6 => 'South Garo Hills',
              7 => 'South West Garo Hills ',
              8 => 'South West Khasi Hills',
              9 => 'West Garo Hills',
              10 => 'West Jaintia Hills',
              11 => 'West Khasi Hills',
            ),
            'Mizoram' => 
            array (
              1 => 'Aizawl',
              2 => 'Champhai',
              3 => 'Kolasib',
              4 => 'Lawngtlai',
              5 => 'Lunglei',
              6 => 'Mamit',
              7 => 'Saiha',
              8 => 'Serchhip',
            ),
            'Nagaland' => 
            array (
              1 => 'Dimapur',
              2 => 'Kiphire',
              3 => 'Kohima',
              4 => 'Longleng',
              5 => 'Mokokchung',
              6 => 'Mon',
              7 => 'Peren',
              8 => 'Phek',
              9 => 'Tuensang',
              10 => 'Wokha',
              11 => 'Zunheboto',
            ),
            'Odisha' => 
            array (
              1 => 'Angul',
              2 => 'Balangir',
              3 => 'Balasore',
              4 => 'Bargarh',
              5 => 'Bhadrak',
              6 => 'Boudh',
              7 => 'Cuttack',
              8 => 'Deogarh',
              9 => 'Dhenkanal',
              10 => 'Gajapati',
              11 => 'Ganjam',
              12 => 'Jagatsinghapur',
              13 => 'Jajpur',
              14 => 'Jharsuguda',
              15 => 'Kalahandi',
              16 => 'Kandhamal',
              17 => 'Kendrapara',
              18 => 'Kendujhar (Keonjhar)',
              19 => 'Khordha',
              20 => 'Koraput',
              21 => 'Malkangiri',
              22 => 'Mayurbhanj',
              23 => 'Nabarangpur',
              24 => 'Nayagarh',
              25 => 'Nuapada',
              26 => 'Puri',
              27 => 'Rayagada',
              28 => 'Sambalpur',
              29 => 'Sonepur',
              30 => 'Sundargarh',
            ),
            'Puducherry' => 
            array (
              1 => 'Karaikal',
              2 => 'Mahe',
              3 => 'Pondicherry',
              4 => 'Yanam',
            ),
            'Punjab' => 
            array (
              1 => 'Amritsar',
              2 => 'Barnala',
              3 => 'Bathinda',
              4 => 'Faridkot',
              5 => 'Fatehgarh Sahib',
              6 => 'Fazilka',
              7 => 'Ferozepur',
              8 => 'Gurdaspur',
              9 => 'Hoshiarpur',
              10 => 'Jalandhar',
              11 => 'Kapurthala',
              12 => 'Ludhiana',
              13 => 'Mansa',
              14 => 'Moga',
              15 => 'Muktsar',
              16 => 'Nawanshahr (Shahid Bhagat Singh Nagar)',
              17 => 'Pathankot',
              18 => 'Patiala',
              19 => 'Rupnagar',
              20 => 'Sahibzada Ajit Singh Nagar (Mohali)',
              21 => 'Sangrur',
              22 => 'Tarn Taran',
            ),
            'Rajasthan' => 
            array (
              1 => 'Ajmer',
              2 => 'Alwar',
              3 => 'Banswara',
              4 => 'Baran',
              5 => 'Barmer',
              6 => 'Bharatpur',
              7 => 'Bhilwara',
              8 => 'Bikaner',
              9 => 'Bundi',
              10 => 'Chittorgarh',
              11 => 'Churu',
              12 => 'Dausa',
              13 => 'Dholpur',
              14 => 'Dungarpur',
              15 => 'Hanumangarh',
              16 => 'Jaipur',
              17 => 'Jaisalmer',
              18 => 'Jalore',
              19 => 'Jhalawar',
              20 => 'Jhunjhunu',
              21 => 'Jodhpur',
              22 => 'Karauli',
              23 => 'Kota',
              24 => 'Nagaur',
              25 => 'Pali',
              26 => 'Pratapgarh',
              27 => 'Rajsamand',
              28 => 'Sawai Madhopur',
              29 => 'Sikar',
              30 => 'Sirohi',
              31 => 'Sri Ganganagar',
              32 => 'Tonk',
              33 => 'Udaipur',
            ),
            'Sikkim' => 
            array (
              1 => 'East Sikkim',
              2 => 'North Sikkim',
              3 => 'South Sikkim',
              4 => 'West Sikkim',
            ),
            'Tamil Nadu' => 
            array (
              1 => 'Ariyalur',
              2 => 'Chennai',
              3 => 'Coimbatore',
              4 => 'Cuddalore',
              5 => 'Dharmapuri',
              6 => 'Dindigul',
              7 => 'Erode',
              8 => 'Kanchipuram',
              9 => 'Kanyakumari',
              10 => 'Karur',
              11 => 'Krishnagiri',
              12 => 'Madurai',
              13 => 'Nagapattinam',
              14 => 'Namakkal',
              15 => 'Nilgiris',
              16 => 'Perambalur',
              17 => 'Pudukkottai',
              18 => 'Ramanathapuram',
              19 => 'Salem',
              20 => 'Sivaganga',
              21 => 'Thanjavur',
              22 => 'Theni',
              23 => 'Thoothukudi (Tuticorin)',
              24 => 'Tiruchirappalli',
              25 => 'Tirunelveli',
              26 => 'Tiruppur',
              27 => 'Tiruvallur',
              28 => 'Tiruvannamalai',
              29 => 'Tiruvarur',
              30 => 'Vellore',
              31 => 'Viluppuram',
              32 => 'Virudhunagar',
            ),
            'Telangana' => 
            array (
              1 => 'Adilabad',
              2 => 'Bhadradri Kothagudem',
              3 => 'Hyderabad',
              4 => 'Jagtial',
              5 => 'Jangaon',
              6 => 'Jayashankar Bhoopalpally',
              7 => 'Jogulamba Gadwal',
              8 => 'Kamareddy',
              9 => 'Karimnagar',
              10 => 'Khammam',
              11 => 'Komaram Bheem Asifabad',
              12 => 'Mahabubabad',
              13 => 'Mahabubnagar',
              14 => 'Mancherial',
              15 => 'Medak',
              16 => 'Medchal',
              17 => 'Nagarkurnool',
              18 => 'Nalgonda',
              19 => 'Nirmal',
              20 => 'Nizamabad',
              21 => 'Peddapalli',
              22 => 'Rajanna Sircilla',
              23 => 'Rangareddy',
              24 => 'Sangareddy',
              25 => 'Siddipet',
              26 => 'Suryapet',
              27 => 'Vikarabad',
              28 => 'Wanaparthy',
              29 => 'Warangal (Rural)',
              30 => 'Warangal (Urban)',
              31 => 'Yadadri Bhuvanagiri',
            ),
            'Tripura' => 
            array (
              1 => 'Dhalai',
              2 => 'Gomati',
              3 => 'Khowai',
              4 => 'North Tripura',
              5 => 'Sepahijala',
              6 => 'South Tripura',
              7 => 'Unakoti',
              8 => 'West Tripura',
            ),
            'Uttarakhand' => 
            array (
              1 => 'Almora',
              2 => 'Bageshwar',
              3 => 'Chamoli',
              4 => 'Champawat',
              5 => 'Dehradun',
              6 => 'Haridwar',
              7 => 'Nainital',
              8 => 'Pauri Garhwal',
              9 => 'Pithoragarh',
              10 => 'Rudraprayag',
              11 => 'Tehri Garhwal',
              12 => 'Udham Singh Nagar',
              13 => 'Uttarkashi',
            ),
            'Uttar Pradesh' => 
            array (
              1 => 'Agra',
              2 => 'Aligarh',
              3 => 'Allahabad',
              4 => 'Ambedkar Nagar',
              5 => 'Amethi (Chatrapati Sahuji Mahraj Nagar)',
              6 => 'Amroha (J.P. Nagar)',
              7 => 'Auraiya',
              8 => 'Azamgarh',
              9 => 'Baghpat',
              10 => 'Bahraich',
              11 => 'Ballia',
              12 => 'Balrampur',
              13 => 'Banda',
              14 => 'Barabanki',
              15 => 'Bareilly',
              16 => 'Basti',
              17 => 'Bhadohi',
              18 => 'Bijnor',
              19 => 'Budaun',
              20 => 'Bulandshahr',
              21 => 'Chandauli',
              22 => 'Chitrakoot',
              23 => 'Deoria',
              24 => 'Etah',
              25 => 'Etawah',
              26 => 'Faizabad',
              27 => 'Farrukhabad',
              28 => 'Fatehpur',
              29 => 'Firozabad',
              30 => 'Gautam Buddha Nagar',
              31 => 'Ghaziabad',
              32 => 'Ghazipur',
              33 => 'Gonda',
              34 => 'Gorakhpur',
              35 => 'Hamirpur',
              36 => 'Hapur (Panchsheel Nagar)',
              37 => 'Hardoi',
              38 => 'Hathras',
              39 => 'Jalaun',
              40 => 'Jaunpur',
              41 => 'Jhansi',
              42 => 'Kannauj',
              43 => 'Kanpur Dehat',
              44 => 'Kanpur Nagar',
              45 => 'Kanshiram Nagar (Kasganj)',
              46 => 'Kaushambi',
              47 => 'Kushinagar (Padrauna)',
              48 => 'Lakhimpur - Kheri',
              49 => 'Lalitpur',
              50 => 'Lucknow',
              51 => 'Maharajganj',
              52 => 'Mahoba',
              53 => 'Mainpuri',
              54 => 'Mathura',
              55 => 'Mau',
              56 => 'Meerut',
              57 => 'Mirzapur',
              58 => 'Moradabad',
              59 => 'Muzaffarnagar',
              60 => 'Pilibhit',
              61 => 'Pratapgarh',
              62 => 'RaeBareli',
              63 => 'Rampur',
              64 => 'Saharanpur',
              65 => 'Sambhal (Bhim Nagar)',
              66 => 'Sant Kabir Nagar',
              67 => 'Shahjahanpur',
              68 => 'Shamali (Prabuddh Nagar)',
              69 => 'Shravasti',
              70 => 'Siddharth Nagar',
              71 => 'Sitapur',
              72 => 'Sonbhadra',
              73 => 'Sultanpur',
              74 => 'Unnao',
              75 => 'Varanasi',
            ),
            'West Bengal' => 
            array (
              1 => 'Alipurduar',
              2 => 'Bankura',
              3 => 'Birbhum',
              4 => 'Cooch Behar',
              5 => 'Dakshin Dinajpur (South Dinajpur)',
              6 => 'Darjeeling',
              7 => 'Hooghly',
              8 => 'Howrah',
              9 => 'Jalpaiguri',
              10 => 'Jhargram',
              11 => 'Kalimpong',
              12 => 'Kolkata',
              13 => 'Malda',
              14 => 'Murshidabad',
              15 => 'Nadia',
              16 => 'North 24 Parganas',
              17 => 'Paschim Medinipur (West Medinipur)',
              18 => 'Paschim (West) Burdwan (Bardhaman)',
              19 => 'Purba Burdwan (Bardhaman)',
              20 => 'Purba Medinipur (East Medinipur)',
              21 => 'Purulia',
              22 => 'South 24 Parganas',
              23 => 'Uttar Dinajpur (North Dinajpur)',
            ),
          );
      
      
      $all_country = get_posts( array(
          'post_type' => 'country',
          'numberposts' => -1,
          'orderby' => 'post_title',
          'order' => 'ASC'
      ) );

      if (!empty($all_country)) {
          foreach($all_country as $country){
              $title = $country->post_title;
              if ($title == "India") {
                  // echo $title;
                  // echo "<br>";
                  $c_id = $country->ID;
              }
          }
      }


      foreach ($india as $x => $y)
      {
          //echo "<strong>".$x."</strong><br>";
          $post_state = wp_insert_post(array (
             'post_type' => 'state',
             'post_title' => $x,
             'post_status' => 'publish',
             'comment_status' => 'closed',   // if you prefer
             'ping_status' => 'closed',      // if you prefer
          ));
          update_post_meta($post_state,'_ast_selected_country', $c_id);

          foreach($y as $key => $value)
          {
              //echo $value."</br>";
              $post_id = wp_insert_post(array (
                 'post_type' => 'city',
                 'post_title' => $value,
                 'post_status' => 'publish',
                 'comment_status' => 'closed',   // if you prefer
                 'ping_status' => 'closed',      // if you prefer
              ));
              update_post_meta($post_id,'_ast_selected_state', $post_state);

          }           
      }
  }

  public function ast_currency(){

      global $wpdb;
      $all_currency = array(
        array(
          'code' => 'AFN',
          'countryname' => 'Afghanistan',
          'name' => 'Afghanistan Afghani',
          'symbol' => '&#1547;'
        ),

        array(
          'code' => 'ARS',
          'countryname' => 'Argentina',
          'name' => 'Argentine Peso',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'AWG',
          'countryname' => 'Aruba',
          'name' => 'Aruban florin',
          'symbol' => '&#402;'
        ),

        array(
          'code' => 'AUD',
          'countryname' => 'Australia',
          'name' => 'Australian Dollar',
          'symbol' => '&#65;&#36;'
        ),

        array(
          'code' => 'AZN',
          'countryname' => 'Azerbaijan',
          'name' => 'Azerbaijani Manat',
          'symbol' => '&#8380;'
        ),

        array(
          'code' => 'BSD',
          'countryname' => 'The Bahamas',
          'name' => 'Bahamas Dollar',
          'symbol' => '&#66;&#36;'
        ),

        array(
          'code' => 'BBD',
          'countryname' => 'Barbados',
          'name' => 'Barbados Dollar',
          'symbol' => '&#66;&#100;&#115;&#36;'
        ),

        array(
          'code' => 'BDT',
          'countryname' => 'People\'s Republic of Bangladesh',
          'name' => 'Bangladeshi taka',
          'symbol' => '&#2547;'
        ),

        array(
          'code' => 'BYN',
          'countryname' => 'Belarus',
          'name' => 'Belarus Ruble',
          'symbol' => '&#66;&#114;'
        ),

        array(
          'code' => 'BZD',
          'countryname' => 'Belize',
          'name' => 'Belize Dollar',
          'symbol' => '&#66;&#90;&#36;'
        ),

        array(
          'code' => 'BMD',
          'countryname' => 'British Overseas Territory of Bermuda',
          'name' => 'Bermudian Dollar',
          'symbol' => '&#66;&#68;&#36;'
        ),

        array(
          'code' => 'BOP',
          'countryname' => 'Bolivia',
          'name' => 'Boliviano',
          'symbol' => '&#66;&#115;'
        ),

        array(
          'code' => 'BAM',
          'countryname' => 'Bosnia and Herzegovina',
          'name' => 'Bosnia-Herzegovina Convertible Marka',
          'symbol' => '&#75;&#77;'
        ),

        array(
          'code' => 'BWP',
          'countryname' => 'Botswana',
          'name' => 'Botswana pula',
          'symbol' => '&#80;'
        ),

        array(
          'code' => 'BGN',
          'countryname' => 'Bulgaria',
          'name' => 'Bulgarian lev',
          'symbol' => '&#1083;&#1074;'
        ),

        array(
          'code' => 'BRL',
          'countryname' => 'Brazil',
          'name' => 'Brazilian real',
          'symbol' => '&#82;&#36;'
        ),

        array(
          'code' => 'BND',
          'countryname' => 'Sultanate of Brunei',
          'name' => 'Brunei dollar',
          'symbol' => '&#66;&#36;'
        ),

        array(
          'code' => 'KHR',
          'countryname' => 'Cambodia',
          'name' => 'Cambodian riel',
          'symbol' => '&#6107;'
        ),

        array(
          'code' => 'CAD',
          'countryname' => 'Canada',
          'name' => 'Canadian dollar',
          'symbol' => '&#67;&#36;'
        ),

        array(
          'code' => 'KYD',
          'countryname' => 'Cayman Islands',
          'name' => 'Cayman Islands dollar',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'CLP',
          'countryname' => 'Chile',
          'name' => 'Chilean peso',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'CNY',
          'countryname' => 'China',
          'name' => 'Chinese Yuan Renminbi',
          'symbol' => '&#165;'
        ),

        array(
          'code' => 'COP',
          'countryname' => 'Colombia',
          'name' => 'Colombian peso',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'CRC',
          'countryname' => 'Costa Rica',
          'name' => 'Costa Rican colón',
          'symbol' => '&#8353;'
        ),

        array(
          'code' => 'HRK',
          'countryname' => 'Croatia',
          'name' => 'Croatian kuna',
          'symbol' => '&#107;&#110;'
        ),

        array(
          'code' => 'CUP',
          'countryname' => 'Cuba',
          'name' => 'Cuban peso',
          'symbol' => '&#8369;'
        ),

        array(
          'code' => 'CZK',
          'countryname' => 'Czech Republic',
          'name' => 'Czech koruna',
          'symbol' => '&#75;&#269;'
        ),

        array(
          'code' => 'DKK',
          'countryname' => 'Denmark, Greenland, and the Faroe Islands',
          'name' => 'Danish krone',
          'symbol' => '&#107;&#114;'
        ),

        array(
          'code' => 'DOP',
          'countryname' => 'Dominican Republic',
          'name' => 'Dominican peso',
          'symbol' => '&#82;&#68;&#36;'
        ),

        array(
          'code' => 'XCD',
          'countryname' => 'Antigua and Barbuda, Commonwealth of Dominica, Grenada, Montserrat, St. Kitts and Nevis, Saint Lucia and St. Vincent and the Grenadines',
          'name' => 'Eastern Caribbean dollar',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'EGP',
          'countryname' => 'Egypt',
          'name' => 'Egyptian pound',
          'symbol' => '&#163;'
        ),

        array(
          'code' => 'SVC',
          'countryname' => 'El Salvador',
          'name' => 'Salvadoran colón',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'EEK',
          'countryname' => 'Estonia',
          'name' => 'Estonian kroon',
          'symbol' => '&#75;&#114;'
        ),

        array(
          'code' => 'EUR',
          'countryname' => 'European Union, Italy, Belgium, Bulgaria, Croatia, Cyprus, Czechia, Denmark, Estonia, Finland, France, Germany, 
                        Greece, Hungary, Ireland, Latvia, Lithuania, Luxembourg, Malta, Netherlands, Poland, 
                        Portugal, Romania, Slovakia, Slovenia, Spain, Sweden',
          'name' => 'Euro',
          'symbol' => '&#8364;'
        ),

        array(
          'code' => 'FKP',
          'countryname' => 'Falkland Islands',
          'name' => 'Falkland Islands (Malvinas) Pound',
          'symbol' => '&#70;&#75;&#163;'
        ),

        array(
          'code' => 'FJD',
          'countryname' => 'Fiji',
          'name' => 'Fijian dollar',
          'symbol' => '&#70;&#74;&#36;'
        ),

        array(
          'code' => 'GHC',
          'countryname' => 'Ghana',
          'name' => 'Ghanaian cedi',
          'symbol' => '&#71;&#72;&#162;'
        ),

        array(
          'code' => 'GIP',
          'countryname' => 'Gibraltar',
          'name' => 'Gibraltar pound',
          'symbol' => '&#163;'
        ),

        array(
          'code' => 'GTQ',
          'countryname' => 'Guatemala',
          'name' => 'Guatemalan quetzal',
          'symbol' => '&#81;'
        ),

        array(
          'code' => 'GGP',
          'countryname' => 'Guernsey',
          'name' => 'Guernsey pound',
          'symbol' => '&#81;'
        ),

        array(
          'code' => 'GYD',
          'countryname' => 'Guyana',
          'name' => 'Guyanese dollar',
          'symbol' => '&#71;&#89;&#36;'
        ),

        array(
          'code' => 'HNL',
          'countryname' => 'Honduras',
          'name' => 'Honduran lempira',
          'symbol' => '&#76;'
        ),

        array(
          'code' => 'HKD',
          'countryname' => 'Hong Kong',
          'name' => 'Hong Kong dollar',
          'symbol' => '&#72;&#75;&#36;'
        ),

        array(
          'code' => 'HUF',
          'countryname' => 'Hungary',
          'name' => 'Hungarian forint',
          'symbol' => '&#70;&#116;'
        ),

        array(
          'code' => 'ISK',
          'countryname' => 'Iceland',
          'name' => 'Icelandic króna',
          'symbol' => '&#237;&#107;&#114;'
        ),

        array(
          'code' => 'INR',
          'countryname' => 'India',
          'name' => 'Indian rupee',
          'symbol' => '&#8377;'
        ),

        array(
          'code' => 'IDR',
          'countryname' => 'Indonesia',
          'name' => 'Indonesian rupiah',
          'symbol' => '&#82;&#112;'
        ),

        array(
          'code' => 'IRR',
          'countryname' => 'Iran',
          'name' => 'Iranian rial',
          'symbol' => '&#65020;'
        ),

        array(
          'code' => 'IMP',
          'countryname' => 'Isle of Man',
          'name' => 'Manx pound',
          'symbol' => '&#163;'
        ),

        array(
          'code' => 'ILS',
          'countryname' => 'Israel, Palestinian territories of the West Bank and the Gaza Strip',
          'name' => 'Israeli Shekel',
          'symbol' => '&#8362;'
        ),

        array(
          'code' => 'JMD',
          'countryname' => 'Jamaica',
          'name' => 'Jamaican dollar',
          'symbol' => '&#74;&#36;'
        ),

        array(
          'code' => 'JPY',
          'countryname' => 'Japan',
          'name' => 'Japanese yen',
          'symbol' => '&#165;'
        ),

        array(
          'code' => 'JEP',
          'countryname' => 'Jersey',
          'name' => 'Jersey pound',
          'symbol' => '&#163;'
        ),

        array(
          'code' => 'KZT',
          'countryname' => 'Kazakhstan',
          'name' => 'Kazakhstani tenge',
          'symbol' => '&#8376;'
        ),

        array(
          'code' => 'KPW',
          'countryname' => 'North Korea',
          'name' => 'North Korean won',
          'symbol' => '&#8361;'
        ),

        array(
          'code' => 'KPW',
          'countryname' => 'South Korea',
          'name' => 'South Korean won',
          'symbol' => '&#8361;'
        ),

        array(
          'code' => 'KGS',
          'countryname' => 'Kyrgyz Republic',
          'name' => 'Kyrgyzstani som',
          'symbol' => '&#1083;&#1074;'
        ),

        array(
          'code' => 'LAK',
          'countryname' => 'Laos',
          'name' => 'Lao kip',
          'symbol' => '&#8365;'
        ),

        array(
          'code' => 'LAK',
          'countryname' => 'Laos',
          'name' => 'Latvian lats',
          'symbol' => '&#8364;'
        ),

        array(
          'code' => 'LVL',
          'countryname' => 'Laos',
          'name' => 'Latvian lats',
          'symbol' => '&#8364;'
        ),

        array(
          'code' => 'LBP',
          'countryname' => 'Lebanon',
          'name' => 'Lebanese pound',
          'symbol' => '&#76;&#163;'
        ),

        array(
          'code' => 'LRD',
          'countryname' => 'Liberia',
          'name' => 'Liberian dollar',
          'symbol' => '&#76;&#68;&#36;'
        ),

        array(
          'code' => 'LTL',
          'countryname' => 'Lithuania',
          'name' => 'Lithuanian litas',
          'symbol' => '&#8364;'
        ),

        array(
          'code' => 'MKD',
          'countryname' => 'North Macedonia',
          'name' => 'Macedonian denar',
          'symbol' => '&#1076;&#1077;&#1085;'
        ),

        array(
          'code' => 'MYR',
          'countryname' => 'Malaysia',
          'name' => 'Malaysian ringgit',
          'symbol' => '&#82;&#77;'
        ),

        array(
          'code' => 'MUR',
          'countryname' => 'Mauritius',
          'name' => 'Mauritian rupee',
          'symbol' => '&#82;&#115;'
        ),

        array(
          'code' => 'MXN',
          'countryname' => 'Mexico',
          'name' => 'Mexican peso',
          'symbol' => '&#77;&#101;&#120;&#36;'
        ),

        array(
          'code' => 'MNT',
          'countryname' => 'Mongolia',
          'name' => 'Mongolian tögrög',
          'symbol' => '&#8366;'
        ),


        array(
          'code' => 'MZN',
          'countryname' => 'Mozambique',
          'name' => 'Mozambican metical',
          'symbol' => '&#77;&#84;'
        ),

        array(
          'code' => 'NAD',
          'countryname' => 'Namibia',
          'name' => 'Namibian dollar',
          'symbol' => '&#78;&#36;'
        ),

        array(
          'code' => 'NPR',
          'countryname' => 'Federal Democratic Republic of Nepal',
          'name' => 'Nepalese rupee',
          'symbol' => '&#82;&#115;&#46;'
        ),

        array(
          'code' => 'ANG',
          'countryname' => 'Curaçao and Sint Maarten',
          'name' => 'Netherlands Antillean guilder',
          'symbol' => '&#402;'
        ),

        array(
          'code' => 'NZD',
          'countryname' => 'New Zealand, the Cook Islands, Niue, the Ross Dependency, Tokelau, the Pitcairn Islands',
          'name' => 'New Zealand dollar',
          'symbol' => '&#36;'
        ),


        array(
          'code' => 'NIO',
          'countryname' => 'Nicaragua',
          'name' => 'Nicaraguan córdoba',
          'symbol' => '&#67;&#36;'
        ),

        array(
          'code' => 'NGN',
          'countryname' => 'Nigeria',
          'name' => 'Nigerian naira',
          'symbol' => '&#8358;'
        ),

        array(
          'code' => 'NOK',
          'countryname' => 'Norway and its dependent territories',
          'name' => 'Norwegian krone',
          'symbol' => '&#107;&#114;'
        ),

        array(
          'code' => 'OMR',
          'countryname' => 'Oman',
          'name' => 'Omani rial',
          'symbol' => '&#65020;'
        ),

        array(
          'code' => 'PKR',
          'countryname' => 'Pakistan',
          'name' => 'Pakistani rupee',
          'symbol' => '&#82;&#115;'
        ),

        array(
          'code' => 'PAB',
          'countryname' => 'Panama',
          'name' => 'Panamanian balboa',
          'symbol' => '&#66;&#47;&#46;'
        ),

        array(
          'code' => 'PYG',
          'countryname' => 'Paraguay',
          'name' => 'Paraguayan Guaraní',
          'symbol' => '&#8370;'
        ),

        array(
          'code' => 'PEN',
          'countryname' => 'Peru',
          'name' => 'Sol',
          'symbol' => '&#83;&#47;&#46;'
        ),

        array(
          'code' => 'PHP',
          'countryname' => 'Philippines',
          'name' => 'Philippine peso',
          'symbol' => '&#8369;'
        ),

        array(
          'code' => 'PLN',
          'countryname' => 'Poland',
          'name' => 'Polish złoty',
          'symbol' => '&#122;&#322;'
        ),

        array(
          'code' => 'QAR',
          'countryname' => 'State of Qatar',
          'name' => 'Qatari Riyal',
          'symbol' => '&#65020;'
        ),

        array(
          'code' => 'RON',
          'countryname' => 'Romania',
          'name' => 'Romanian leu (Leu românesc)',
          'symbol' => '&#76;'
        ),

        array(
          'code' => 'RUB',
          'countryname' => 'Russian Federation, Abkhazia and South Ossetia, Donetsk and Luhansk',
          'name' => 'Russian ruble',
          'symbol' => '&#8381;'
        ),


        array(
          'code' => 'SHP',
          'countryname' => 'Saint Helena, Ascension and Tristan da Cunha',
          'name' => 'Saint Helena pound',
          'symbol' => '&#163;'
        ),

        array(
          'code' => 'SAR',
          'countryname' => 'Saudi Arabia',
          'name' => 'Saudi riyal',
          'symbol' => '&#65020;'
        ),

        array(
          'code' => 'RSD',
          'countryname' => 'Serbia',
          'name' => 'Serbian dinar',
          'symbol' => '&#100;&#105;&#110;'
        ),

        array(
          'code' => 'SCR',
          'countryname' => 'Seychelles',
          'name' => 'Seychellois rupee',
          'symbol' => '&#82;&#115;'
        ),

        array(
          'code' => 'SGD',
          'countryname' => 'Singapore',
          'name' => 'Singapore dollar',
          'symbol' => '&#83;&#36;'
        ),

        array(
          'code' => 'SBD',
          'countryname' => 'Solomon Islands',
          'name' => 'Solomon Islands dollar',
          'symbol' => '&#83;&#73;&#36;'
        ),

        array(
          'code' => 'SOS',
          'countryname' => 'Somalia',
          'name' => 'Somali shilling',
          'symbol' => '&#83;&#104;&#46;&#83;&#111;'
        ),

        array(
          'code' => 'ZAR',
          'countryname' => 'South Africa',
          'name' => 'South African rand',
          'symbol' => '&#82;'
        ),

        array(
          'code' => 'LKR',
          'countryname' => 'Sri Lanka',
          'name' => 'Sri Lankan rupee',
          'symbol' => '&#82;&#115;'
        ),


        array(
          'code' => 'SEK',
          'countryname' => 'Sweden',
          'name' => 'Swedish krona',
          'symbol' => '&#107;&#114;'
        ),


        array(
          'code' => 'CHF',
          'countryname' => 'Switzerland',
          'name' => 'Swiss franc',
          'symbol' => '&#67;&#72;&#102;'
        ),

        array(
          'code' => 'SRD',
          'countryname' => 'Suriname',
          'name' => 'Suriname Dollar',
          'symbol' => '&#83;&#114;&#36;'
        ),

        array(
          'code' => 'SYP',
          'countryname' => 'Syria',
          'name' => 'Syrian pound',
          'symbol' => '&#163;&#83;'
        ),

        array(
          'code' => 'TWD',
          'countryname' => 'Taiwan',
          'name' => 'New Taiwan dollar',
          'symbol' => '&#78;&#84;&#36;'
        ),


        array(
          'code' => 'THB',
          'countryname' => 'Thailand',
          'name' => 'Thai baht',
          'symbol' => '&#3647;'
        ),


        array(
          'code' => 'TTD',
          'countryname' => 'Trinidad and Tobago',
          'name' => 'Trinidad and Tobago dollar',
          'symbol' => '&#84;&#84;&#36;'
        ),


        array(
          'code' => 'TRY',
          'countryname' => 'Turkey, Turkish Republic of Northern Cyprus',
          'name' => 'Turkey Lira',
          'symbol' => '&#8378;'
        ),

        array(
          'code' => 'TVD',
          'countryname' => 'Tuvalu',
          'name' => 'Tuvaluan dollar',
          'symbol' => '&#84;&#86;&#36;'
        ),

        array(
          'code' => 'UAH',
          'countryname' => 'Ukraine',
          'name' => 'Ukrainian hryvnia',
          'symbol' => '&#8372;'
        ),


        array(
          'code' => 'GBP',
          'countryname' => 'United Kingdom, Jersey, Guernsey, the Isle of Man, Gibraltar, South Georgia and the South Sandwich Islands, the British Antarctic Territory, and Tristan da Cunha',
          'name' => 'Pound sterling',
          'symbol' => '&#163;'
        ),


        array(
          'code' => 'UGX',
          'countryname' => 'Uganda',
          'name' => 'Ugandan shilling',
          'symbol' => '&#85;&#83;&#104;'
        ),


        array(
          'code' => 'USD',
          'countryname' => 'United States',
          'name' => 'United States dollar',
          'symbol' => '&#36;'
        ),

        array(
          'code' => 'UYU',
          'countryname' => 'Uruguayan',
          'name' => 'Peso Uruguayolar',
          'symbol' => '&#36;&#85;'
        ),

        array(
          'code' => 'UZS',
          'countryname' => 'Uzbekistan',
          'name' => 'Uzbekistani soʻm',
          'symbol' => '&#1083;&#1074;'
        ),

        array(
          'code' => 'VEF',
          'countryname' => 'Venezuela',
          'name' => 'Venezuelan bolívar',
          'symbol' => '&#66;&#115;'
        ),

        array(
          'code' => 'VND',
          'countryname' => 'Vietnam',
          'name' => 'Vietnamese dong (Đồng)',
          'symbol' => '&#8363;'
        ),

        array(
          'code' => 'VND',
          'countryname' => 'Yemen',
          'name' => 'Yemeni rial',
          'symbol' => '&#65020;'
        ),

        array(
          'code' => 'ZWD',
          'countryname' => 'Zimbabwe',
          'name' => 'Zimbabwean dollar',
          'symbol' => '&#90;&#36;'
        ),
      ); 
    
      $table_list = get_option("ast_table_name");
      foreach($table_list as $key => $value){
          if ($key == "ast_event_currency") {
              $currency_table = $value;                                   
          }
      }   

      foreach ($all_currency as $currency)
      {          
          $data=array(
            'countrycode' => $currency['code'], 
            'countryname' => $currency['countryname'],
            'currencyname' => $currency['name'], 
            'symbol' => $currency['symbol']
          );
          $wpdb->insert( $currency_table, $data);        
      } 

  }

  public function ast_check_woocommerce_activate(){

      // Require parent plugin
      if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) and current_user_can( 'activate_plugins' ) ) {
          // Stop activation redirect and show error
          wp_die('Sorry, but this plugin requires the Woocommerce Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
      }
  }


   


}
