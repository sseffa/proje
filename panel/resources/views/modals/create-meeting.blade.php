<div class="modal fade modal-backdrop-transparent" id="create-meeting" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('create.meeting') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Toplantı Oluştur</h5>
                    <hr/>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="content">Açıklama</label>
                        <textarea class="form-control" name="content" id="content" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="meet_date">Toplantı Zamanı</label>
                        <input class="form-control" type="datetime-local" name="meet_date" value="{{ date('Y-m-d H:i:s') }}"
                               id="">
                    </div>
                </div>
                <input type="hidden" value="{{ $team_id }}" name="team_id">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Oluştur</button>
                </div>
            </form>
        </div>
    </div>
</div>

