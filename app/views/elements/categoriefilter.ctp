<div id="categoriefilter">
    <h3>Subcategori&euml;n</h3>
    <?php
        // pad naar deze categorie
        if(isset($path))
        {
            $url = '/';
            $i = 0;
            echo '<ul id="pli-path">';
            foreach($path as $id => $categorie)
            {
                $i++;
                $url .= $categorie['Categorie']['slug'] . '/';
                print '<li class="' . ($i == count($path) ? 'last' : '') . '">' . $html->link($categorie['Categorie']['naam'], $url) . '</li>';
            }
            echo '</ul>';
        }
        
        // subcategorien laatste in pad
        echo '<ul id="pli-children">';
        foreach($children as $subcategorie)
        {
            print '<li>' . $html->link($subcategorie['Categorie']['naam'], $url . '/' . $subcategorie['Categorie']['slug']) . '</li>';
        }
        echo '</ul>';
    ?>
    
    <h3>Merken</h3>
    <ul id="pli-merken">
    <?php
        print '<li>' . $html->link('alle merken', $url) . '</li>';
        foreach($merken as $slug => $naam)
        {
            print '<li>' . $html->link($naam, $url . '/merk:' . $slug) . '</li>';
        }
    ?>
    </ul>
</div>