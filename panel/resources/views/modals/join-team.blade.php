<div class="modal fade modal-backdrop-transparent" id="join-team" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ekibe Katıl</h5>
                <hr />
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    Ekip kodunu kullanarak istediğiniz ekibe, katılabilirsiniz.
                </div>


                <input type="hidden" value="{{ auth()->id() }}" name="user_id" id="userId"/>
                <div class="form-group col-sm-12">
                    <label class="form-label" for="code">Ekip Kodu</label>
                    <input type="text" id="code" name="code" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-join" data-dismiss="modal">Katıl</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    document.querySelector('.btn-join').addEventListener('click', async function () {


        let userId = document.querySelector('#userId').getAttribute('value');
        let code = document.querySelector('#code').value;
        let token = document.querySelector('meta[name="_token"]').getAttribute('content');

        fetch('/teams/joinTeam', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            //credentials: "same-origin",
            body: JSON.stringify({
                userId: parseInt(userId),
                code: code
            })
        })
            .then(response => response.json())
            .then(result => {

                if (result.status === "success") {

                    $('#join-team').hide();
                    bootbox.alert("Başarıyla ekibe katıldınız.");
                    location.reload();
                    return true;
                }

                bootbox.alert(result.message);

            })
            .catch(function (error) {
                console.log(error);
            });
    });
</script>
