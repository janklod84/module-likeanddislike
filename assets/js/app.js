$(document).ready(function(){

	    var $vote = $('#vote');

	    $('.vote_like', $vote).click(function(e){
            
            e.preventDefault();
	        vote(1);
	       
	    });

	    $('.vote_dislike', $vote).click(function(e){
            
            e.preventDefault();
	        vote(-1);
	       
	    });


        function vote(value)
        {
               $('.vote_loading').show();
               $('.vote_btns').hide();

               $.post('index.php?p=like', {
		            ref: $vote.data('ref'),
		            ref_id: $vote.data('ref_id'),
		            user_id: $vote.data('user_id'),
		            vote: value

		        }).done(function(data, textStatus, jqXHR){ // cas de success
		           
		           console.log(data);
                   
                   // Mise ajour des compteurs like et dislike
		           $('#dislike_count').text(data.dislike_count);
		           $('#like_count').text(data.like_count);
                   
                   $vote.removeClass('is-liked is-disliked');

                   if(data.success)
                   {
                   	   if(value == 1)
	                   {
	                   	   $vote.addClass('is-liked');

	                   }else{

	                   	  $vote.addClass('is-disliked');
	                   }
                   
                   }

                   
                   // var divider = parseInt(data.dislike_count) + parseInt(data.like_count);
                   // var res = data.like_count / divider;
                   // var percentage = Math.round(100 * res);

                   var percentage = Math.round(100 * (data.like_count / (parseInt(data.dislike_count) + parseInt(data.like_count))));
                   $('.vote_progress').css('width', percentage + '%');

		        }).fail(function(jqXHR, textStatus, errorThrown){ // cas d'echec

		             // console.log(jqXHR);
		             alert(jqXHR.responseText);

		        }).always(function(){ 

		             // Dans tous les cas fait l'instruction ci
		        	  $('.vote_loading').hide();
                      $('.vote_btns').fadeIn();
		        });
        }
});