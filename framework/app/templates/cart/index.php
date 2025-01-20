<div style="padding-top: 10px">
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">PricePerItem</th>
        <th scope="col">Quantity</th>
        <th scope="col">TotalPrice</th>
        <th scope="col">x</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($items as $key => $item): ?>
        <tr>
            <th scope="row"><?= $key ?></th>
            <td><?= $item->getTitle() ?></td>
            <td><?= $item->getPrice() ?></td>
            <td><?= $item->getQuantity() ?></td>
            <td><?= $item->getQuantity() * $item->getPrice() ?></td>
            <td>
                <form action="/cart/delete" method="POST">
                    <input type="hidden" name="inventory_id" value="<?=$item->getId()?>">
                    <button href="/cart/delete/<?=$item->getId()?>" class="btn btn-danger">X</button>

                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<form action="/cart/add" method="POST" style="padding-top: 20px">
    <div class="form-group">
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label for="inventoryId">Inventory ID</label>
        <input type="text" class="form-control" id="inventoryId" placeholder="Enter inventory ID"
               name="inventory_id">
    </div>
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="text" class="form-control" id="quantity" placeholder="Quantity" name="quantity">
    </div>

    <input type="submit" value="ADD"/>
</form>
</div>