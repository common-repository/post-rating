<?PHP

class post_rate_ajax {
	
	public function __construct() {	
		add_action( 'wp_ajax_nopriv_mark_post_submit', array($this, 'mark_post_submit') );
		add_action( 'wp_ajax_mark_post_submit', array($this, 'mark_post_submit') );
		add_action( 'wp_enqueue_scripts', array($this,'display_javascript') );
	}
	
	function display_javascript($hook) {
	
		wp_enqueue_script( 'mark_post', plugins_url('/js/mark_post.js', __FILE__), array('jquery'));		
		wp_localize_script( 'mark_post', 'mark_post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'answerNonce' => wp_create_nonce( 'mark_post_nonce' ) ) );
	
	}
	
	function mark_post_submit(){

		if(wp_verify_nonce($_REQUEST['nonce'], 'mark_post_nonce')){
			
			add_post_meta($_POST['id'], "post_rating_score", $_POST['mark']);
		
		}
		
		$feedback = get_post_meta($_POST['id'], "post_feedback");
		
		if(isset($feedback[0]) && $feedback[0]!=""){
		
			echo $feedback[0];
		
		}else{
		
			echo "Thank you";
		
		}
		
		die();
	
	}

} 

$post_rating_ajax = new post_rate_ajax();
