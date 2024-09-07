(function($) {
    // Funkcia na pridanie nového súboru
    $(document).on('click', '.add-more-files', function() {
        var newInput = $(this).closest('.form-group').clone(); // Klonovanie celý form-group
        newInput.find('input').val(''); // Vyčisti hodnotu klonovaného inputu
        newInput.insertAfter($(this).closest('.form-group')); // Vlož klonovaný input za aktuálny
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var discussion = $('#discussion');
        var url = discussion.data('url'); // Získaj URL z dátového atribútu

        // Funkcia na pridanie komentára
        $('#add-comment-form').on('submit', function(event) {
            event.preventDefault(); // Zabrániť defaultnej akcii odoslania formulára

            var form = $(this);
            var data = form.serialize(); // Získať údaje z formulára

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    var newComment = $(response.html).hide(); // Skryť nový komentár
                    discussion.append(newComment.fadeIn()); // Pridať a zobraziť nový komentár
                    form.find('textarea').val(''); // Vyčistiť textareu
                },
                error: function(response) {
                    console.log(response.responseText); // Skontroluj detaily chyby
                    alert('Nepodarilo sa pridať komentár. Skúste to znova.');
                }
            });
        });

        // Funkcia na mazanie komentára
        discussion.on('click', '.delete-comment', function(event) {
            event.preventDefault();

            if (!confirm('Naozaj chcete vymazať tento komentár?')) {
                return;
            }

            var button = $(this);

            var commentId = button.data('id');


            if (!commentId) {
                alert('Nemožno získať ID komentára. Skúste to znova.');
                return;
            }

            var url = '/comments/' + commentId;

            console.log('Comment ID:', commentId);

            console.log('Sending DELETE request to:', url);

            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function(response) {
                    console.log('AJAX delete successful:', response);


                    if (response.success) {
                        // Odstránenie komentára z DOMu
                        var commentElement = $('#comment-' + commentId);
                        console.log('Comment element:', commentElement);

                        commentElement.fadeOut(400, function() {
                            $(this).remove(); // Odstrániť element z DOMu
                            console.log('Comment removed from DOM');
                        });
                    } else {

                        alert('Nepodarilo sa vymazať komentár. Skúste to znova.');
                        console.log('Delete failed with response:', response);
                    }
                },
                error: function(xhr) {
                    console.log('Error response:', xhr.responseText);
                    alert('Nepodarilo sa vymazať komentár. Skúste to znova.');
                }
            });
        });
    });



	/**
	 * INSERT FORM
	 */
	var form  = $('#add-form'),
	    list  = $('#item-list'),
	    input = form.find('#text');

	input.val('').focus();


	/**
	 * EDIT FORM
	 */
	$('#edit-form').find('#text').select();


	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function() {
		return confirm('for sure?');
	});




})(jQuery);
