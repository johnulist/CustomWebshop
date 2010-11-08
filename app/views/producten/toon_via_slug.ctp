<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<?php
    // pagination en sortering
    echo '<div id="listcontrols">';

        echo '<div id="sort">';
            echo '<form method="post" action="">';
            echo '<label for="sort">Sorteer op</label>';
            echo '<select onchange="this.form.submit()" name="sort">';

            foreach($sortOrders as $key => $data)
            {
                $select = ($key == $sortOrder ? ' selected="selected"' : '');
                echo '<option value="' . $key . '"' . $select . '>' . $data['label'] . '</option>';
            }

            echo '</select>';
            echo '</form>';
        echo '</div>';

        echo '<div id="paging">';
            if($paginator->hasPrev()) echo $paginator->prev('&laquo', array('escape' => false)) . ' ';
            echo $paginator->numbers();
            if($paginator->hasNext()) echo ' ' . $paginator->next('&raquo', array('escape' => false));
        echo '</div>';

        echo '<div class="clear"></div>';

    echo '</div>';

    // producten
    echo $this->element('producten', array(
        'categorie' => $categorie['Categorie']['naam'],
        'data' => $this->data
    ));
?>
