<!-- Modal -->
<div class="modal fade" id="orderModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Table Orders</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5>Table no: {{occupiedTable}}</h5>
                <h5>Order Id: {{orderDetailsArray[0].orderID}}</h5>
                <table class="table table-striped table-hover">
                    <tr>
                         <th>Food ID</th>
                         <th>Quantity</th>
                         <th>Total</th>
                     </tr>
                    
                    <tr data-ng-repeat="x in orderDetailsArray">
                        <td>{{x.foodID}}</td>
                        <td>{{x.quantity}}</td>
                        <td>RM{{x.total}}</td>
                      </tr>
                    <p>test</p>
                    <p>{{adminCheck}}</p>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete" data-dismiss="modal">Delete</button> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" onclick="location.href='payment.php'">Pay</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="delete" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Are You Sure?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Table no: {{occupiedTable}}</p>
                <p>Order Id: {{orderDetailsArray[0].orderID}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" onclick="location.href=" data-ng-click = deleteOrder() >Yes</button>
            </div>
        </div>
    </div>
</div>