<div class="modal fade" id="modal-finance-account">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">TÀI KHOẢN KẾ TOÁN</h4>
            </div>
            <div class="modal-body">
                <form action="" role="form" id="add_finance_account_form" class="row" >
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <label for="">Cấp tài khoản</label>
                            <select name="level" class="form-control" required="required" id="level">
                                <option value="0">Level 0 </option>
                                <option value="1">Level 1</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Mã</label>
                            <input type="text" class="form-control" name="code" >
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Tên</label>
                            <input type="text" class="form-control" name="name" >
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Dư nợ đầu kì</label>
                            <input type="text" class="form-control" id="surplus_debit" name="surplus_debit" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Dư có đầu kì</label>
                            <input type="text" class="form-control" id="surplus_credit" name="surplus_credit" disabled="">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Tài khoản cha</label>
                            <select name="parent_id" class="form-control" id="parent_id" disabled="">
                                
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="add_finance_account_form" class="btn btn-sm green">Tạo</button>
                </center>
            </div>
        </div>
    </div>
</div>