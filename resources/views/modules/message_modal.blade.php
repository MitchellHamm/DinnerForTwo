<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="messageModalLabel">New Message</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12">
            <form id="sendMessage-form" method="POST" action="{{ route('send-message.submit') }}">
                {{ csrf_field() }}
                <input type="text" class="form-control" id="userId" placeholder="userId" name="userId" value="" style="display:none">
                <textarea rows="8" style="width:100%;" name="message"></textarea>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn green" href="javascript:{}" onclick="document.getElementById('sendMessage-form').submit();">Send Message</a>
</div>
</div>
</div>
</div>

<script>
    $('#messageModal').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        let userId = $(e.relatedTarget).data('user-id');

        //populate the textbox
        $('#userId').attr('value', userId);
    });
</script>