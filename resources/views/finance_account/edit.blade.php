<div class="modal fade" id="modal-finance-account-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">CHỈNH SỬA</h4>
            </div>
            <div class="modal-body">
                <form action="" role="form" id="edit_finance_account_form" class="row" >
                    <div class="col-md-12 row">
                        <div class="form-group col-md-6">
                            <label for="">Mã</label>
                            <input type="text" class="form-control" name="code" id="code_edit">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Tên</label>
                            <input type="text" class="form-control" name="name" id="name_edit">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Dư nợ đầu kì</label>
                            <input type="text" class="form-control" id="surplus_debit_edit" name="surplus_debit">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Dư có đầu kì</label>
                            <input type="text" class="form-control" id="surplus_credit_edit" name="surplus_credit">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Tài khoản cha</label>
                            <select name="parent_id" class="form-control" id="parent_id_edit">
                                
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="edit_finance_account_form" class="btn btn-sm green">Cập nhật</button>
                </center>
            </div>
        </div>
    </div>
</div>