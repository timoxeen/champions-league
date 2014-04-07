<div class="modal fade" id="edit-week-results" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit week results</h4>
      </div>
      <div class="modal-body">
        <form id="results-form">
          <table class="table" id="results-table">
            <tbody></tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-fixture">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$( document ).ready(function() {

  var resultsTableId,
      resultsFormId,
      weekId; 
  
  resultsTableId = '#results-table';
  resultsFormId = '#results-form';

  $('button[id^="edit-week-results-"]').click(function(e) {

    weekId = jQuery.trim($(this).attr('rel'));

    $.ajax({
      url: "/season/ajaxGetWeekResults",
      type: "POST",
      data: {weekId: weekId, seasonId:'<?php echo $data->seasonId; ?>'},
      dataType: "json",
      error: function(xhr, status, error) {
        alert('error' + error + " status: " + xhr.status + " message: " + xhr.responseText);
      },
      success: function(data) {

        if(data['error'] == false) {
          
          $('#edit-week-results').modal({
            keyboard: true
          });

          $(resultsTableId).html('');

          var i=0;
          $.each(data['info'], function(index, row) {
            
            var rowHtml = '';
            rowHtml = rowHtml + '<tr>';
            rowHtml = rowHtml + '<td>' + row['home_team'] + '</td>';
            rowHtml = rowHtml + '<td><input class="form-control" type="text" name="fixture-home-' + row['fixture_id'] + '" value="' + row['home_team_goal'] + '" /></td>'
            rowHtml = rowHtml + '<td>-</td>';
            rowHtml = rowHtml + '<td><input class="form-control" type="text" name="fixture-away-' + row['fixture_id'] + '" value="' + row['away_team_goal'] + '" /></td>';
            rowHtml = rowHtml + '<td>' + row['away_team'] + '</td>';
            rowHtml = rowHtml + '</tr>';

            if(i == 0) {
              $(resultsTableId).prepend(rowHtml);
            } else {
              $(resultsTableId + ' tr:last').after(rowHtml);
            }

            i++;

          });
        } else {
          alert(data['error']);
        }
      }
    });
  });

  $('#save-fixture').click(function(e){
    e.preventDefault();
    var formData;

    formData = $(resultsFormId).serialize();
    formData = formData + '&weekId' + weekId + "&seasonId=<?php echo $data->seasonId; ?>";

    $.ajax({
      url: "/season/ajaxSaveWeekResults",
      type: "GET",
      data: formData,
      dataType: "json",
      error: function(xhr, status, error) {
        alert('error' + error + " status: " + xhr.status + " message: " + xhr.responseText);
      },
      success: function(data) {

        if(data['error'] == false) {
          
          

          });
        } else {
          alert(data['error']);
        }
      }
    });

  });

});
</script>