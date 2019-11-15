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
                <div data-ng-if="orderDetailsArray.length===0">
                    <p>It appears that there is no order for this table....</p>
                    <p>It seems that there is an unpaid order from yesterday.</p>
                    <button class="editX" data-ng-click="updateTable(occupiedTable)" data-dismiss="modal" onclick="window.location.reload();">Update Table</button>
                    <p>Click on the "Update Table" button to make this table available for use.</p>
                </div>
                <div data-ng-if="orderDetailsArray.length!=0">
                    <h6>Table No: {{occupiedTable}}</h6>
                    <h6>Order ID: {{orderDetailsArray[0].orderID}}</h6>

                    <table class="table table-striped tableOrder">
                    <thead>
                        <tr>
                             <th>Food ID</th>
                             <th>Quantity</th>
                             <th>Total</th>
                         </tr>
                    </thead>
                    <tbody>
                        <tr data-ng-repeat="x in orderDetailsArray">
                            <td>{{x.foodID}}</td>
                            <td>{{x.quantity}}</td>
                            <td>RM{{x.total}}</td>
                          </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <div data-ng-if="orderDetailsArray.length!=0">
                <div class="modal-footer">
                    <button type="button" class="btn exitPigeon mr-auto" data-dismiss="modal">Close</button>
                    <button type="button" class="btn editButton" onclick="location.href='editOrder.php'">Edit</button>
                    <?php
                        session_start();
                        if($_SESSION["privilege"] === 1)
                        {
                            echo '<button type="button" class="btn deleteButton" data-toggle="modal" data-target="#delete" data-dismiss="modal">Delete</button>';
                        }
                    ?>
                    <button type="button" class="btn payButton" onclick="location.href='payment.php'">Pay</button>
                </div>
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
                <h4 class="modal-title">Delete this order?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Table No: {{occupiedTable}}</p>
                <p>Order ID: {{orderDetailsArray[0].orderID}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn exitPigeon" data-dismiss="modal">No</button>
                <button type="button" class="btn deleteButton" onclick="window.location.reload();" data-ng-click = deleteOrder() data-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>
