<div class="modal fade" id="edit-week-results" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit week results</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
  $('button[id^="edit-week-results-"]').click(function(e) {
    var weekId;
    weekId = jQuery.trim($(this).attr('rel'));

    $.ajax({
      url: "/season/ajaxWeekResults",
      type: "POST",
      data: {week_id: weekId},
      dataType: "json",
      error: function(xhr, status, error) {
        alert('error' + error + " status: " + xhr.status + " message: " + xhr.responseText);
      },
      success: function(data) {



        $('#edit-week-results').modal({
          keyboard: true
        })
      }
    });
  });
});
</script>