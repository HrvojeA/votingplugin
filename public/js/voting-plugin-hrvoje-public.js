(function( $ ) {
	'use strict';

	$( window ).load(function() {
 		$('.vote-button').on('click', function(e) {
			 e.preventDefault();

			var postId = $(this).data('post-id');
			var voteType = $(this).data('vote-type');


			// AJAX request
			$.ajax({
				type: 'post',
				url: voting_ajax.ajax_url,
				data: {
					action: 'handle_vote',
					post_id: postId,
					vote_type: voteType,
					nonce: voting_ajax.nonce,   // pass the nonce here

				},
				success: function(response) {
					// Handle success, e.g., update UI

					console.log(response);
					handleResults(JSON.parse(response,$(this).data('vote-type')));


				},
				error: function(error) {
					// Handle error
					console.error('Error: ' + error.responseText);
				}
			});
			return false;
		});
	});

	function handleResults(data,voteType){

		if(typeof data.voting_results !== 'undefined'){
			jQuery('.yes-average .results-percentage').text(data.voting_results.yes_percentage);
			jQuery('.no-average .results-percentage').text(data.voting_results.no_percentage)
			jQuery('.voting-block-wrapper').addClass('post-vote');

			jQuery('.'+voteType+'-average').addClass('selected');

		}

	}


})( jQuery );

