<div class="modal fade text-left" id="barcode-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Barcode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="w-100" src="https://barcode.tec-it.com/barcode.ashx?data={{date('d-m-Y', strtotime($item->created_at))}} {{date('d-m-Y', strtotime($item->kedaluwarsa))}}&code=Code128&imagetype=Png" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" href="https://barcode.tec-it.com/barcode.ashx?data={{date('d-m-Y', strtotime($item->created_at))}} {{date('d-m-Y', strtotime($item->kedaluwarsa))}}&code=Code128&imagetype=Png&download=true">Download</a>
            </div>
        </div>
    </div>
</div>