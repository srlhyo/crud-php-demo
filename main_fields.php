        
        <h2 class="my-3">The last 8 Fields</h2>
        <small>***click on the id of the field you wish to delete</small>
        <small><?php echo $isError ? $errorMessage : ""; ?></small>
        <table id="mytable" class="table table-striped table-bordered" style="width:300px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NumberOfTrees</th>
                    <th>AgeOfTrees</th>
                    <th>Edit Rows</th>
                    <th>Delete Rows</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- When using pdo::fetch_assoc, the pdostatement returns an array indexed by column name  -->
                <?php foreach($data as $row) : ?>
                <tr>
                    <td onClick="onIdClicked(this)"><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['NumberOfTrees']); ?></td>
                    <td><?php echo htmlspecialchars($row['AgeOfTrees']); ?>
                    <td><button onClick="populatesFormFields(this)" class="btn btn-outline-primary">Edit</button></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="fieldID">
                            <input type="hidden" name="delete" value="delete">
                            <button type="submit" onclick="deleteButtonHandler()" class="btn btn-outline-danger" style="border-color: #d5a3a8; color: #b76870;" disabled>Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5 mb-3">Your Form</h2>
        <form class="row g-3" method="POST">
            <div class="col-md-6">
                <label for="numbtrees" class="form-label">Number of trees</label>
                <input type="text" name="numberOfTrees" class="form-control" id="numbtrees">
            </div>
            <div class="col-md-6">
                <label for="agetrees" class="form-label">Age of trees</label>
                <input type="text" name="ageOfTrees" class="form-control" id="agetrees">
            </div>

            <input type="hidden" name="fieldID" id="fieldID">
            
            <div class="col-auto mt-3">
                <input type="submit" name="submit" class="btn btn-primary mb-3" value="Add Fields">
            </div>
            <div class="col-auto mt-3">
                <input type="submit" name="submit" class="btn btn-primary mb-3" value="Save Fields">
            </div>
        </form>
        
    </div>