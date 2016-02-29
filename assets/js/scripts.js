
jQuery(document).ready(function() {
	
   /**
    * Fullscreen background
    */
    $.backstretch("assets/img/backgrounds/1.jpg");
    
    /**
     * Login Form validation
     */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    
    /**
     * Register Form validation
     */
    $('.register-form input[type="text"], .register-form input[type="email"], .register-form input[type="password"], .register-form textarea').on('focus', function() {
        $(this).removeClass('input-error');
    });
    
    $('.register-form').on('submit', function(e) {
        
        $(this).find('input[type="text"], input[type="email"], input[type="password"], textarea').each(function(){
            if( $(this).val() == "" ) {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });
        
    });

    /**
     * Highlight active menu item
     */
    var url = window.location;
    // Will only work if string in href matches with location
    $('ul.nav a[href="'+ url +'"]').parent().addClass('active');

    // Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
});
