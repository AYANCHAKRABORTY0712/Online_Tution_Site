$(document).ready(function() {
    $('input[type=radio][name=designation]').on('click', function(e) {
        if (this.value == "teacher") {
            $('#additional_info').html(`<div class="formbold-mb-3">
                <label for="reason" class="formbold-form-label">
                Why do you want to join us?
                </label>
                <textarea
                rows="3"
                name="reason"
                id="reason"
                class="formbold-form-input"
                required
                ></textarea>
            </div>

            <div class="formbold-form-file-flex">
                <label for="upload" class="formbold-form-label">
                Upload Resume
                </label>
                <input
                type="file"
                name="upload"
                id="upload"
                class="formbold-form-file"
                required
                >
            </div>
            <br>
            <div class="formbold-form-file-flex">
                <label for="subject" class="formbold-form-label">
                Your Subject
                </label>
                <select id="subject" name="subject" required>
                    <option>--choose one--</option>
                </select>
            </div>
            <br>`);
        }
        else {
            $('#additional_info').html('');
        }
    });
    
    $('#stream').change(function() {
        var selectedOption = $(this).val();
        //var msg = <?php echo 'Hello World!' ?>;
        //alert(msg);
        // fetch('../vacancy.json')
        // .then(response => response.json())
        // .then(data => console.log(data))
        // .catch(error => console.error('Error:', error));
        //alert(selectedOption);
        var options = [
            { text: '--choose one--', value: '' }
        ];
        $.getJSON('../vacancy.json', function(vacancy) {
            for(var subject of vacancy[selectedOption]) {
                options.push({ text: subject.subname, value: subject.id });
            }
            $('#subject').empty();
            $.each(options, function(i, option) {
                $('#subject').append($('<option/>').attr('value', option.value).text(option.text))
            });
        });
    });
});
