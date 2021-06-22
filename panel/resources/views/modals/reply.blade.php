<div class="modal fade modal-backdrop-transparent" id="add-reply" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="reply-form" action="{{ route('add.reply') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yorum bırak</h5>
                    <hr/>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="message">Yanıtınız</label>
                        <textarea class="form-control" name="message" id="message" rows="5"></textarea>
                    </div>
                </div>
                <input type="hidden" value="" name="post_id" id="post_id">
                <input type="hidden" value="" name="team_id" id="team_id">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Yanıtla</button>
                </div>
            </form>
        </div>
    </div>
</div>

