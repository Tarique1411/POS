<?php
//print_r($pos_register_data);
//print_r($pos_cash_drawer_data);
$register_data = array($pos_register_data, $pos_cash_drawer_data);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" id="cash_details">
                <thead>
                    <tr>
                        <th>Cash When register is opened</th>
                        <th>Cash When register is closed</th>
                        <th>Difference</th>
                    </tr>       
                </thead>
                <tbody>
                    <tr>
                        <td><?= $pos_register_data['total_cash'] ?></td>
                        <td><?= $pos_register_data['total_cash_submitted'] ?></td>
                        <td>
                            <?php
                            $diff = ($pos_register_data['total_cash'] > $pos_register_data['total_cash_submitted']) ? ($pos_register_data['total_cash'] - $pos_register_data['total_cash_submitted']) : ($pos_register_data['total_cash_submitted'] - $pos_register_data['total_cash']);
                            echo $diff;
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form role="form" action="pos/submit_close_register" name="submit_close_register" id="submit_close_register">
                <input type="hidden" name="register_data" value="<?php echo htmlentities(serialize($register_data)); ?>" />
                <input type="submit" name="submit_register" value="Close Register" class="btn btn-primary"/>           
            </form>
        </div>
    </div>
</div>

