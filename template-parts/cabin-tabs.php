
<?php


// Tabs for amenities and rates only (only applies on cabin pages)
if (has_term('Cabins', 'product_cat')) {
?>

    <div id="amenities-rates">
        <ul id="nav-tab" class="nav-tab-ul">
            <li class="active"><a href="#amenities">Amenities</a></li>
            <li><a href="#rates">Rates</a></li>
        </ul>

        <div id="tab-content">
            <section class='tab-pane active' id="amenities">

                <?php
                // Check rows exists.
                if (have_rows('amenities_list')) :
                ?>
                    <h3>Amenities</h3>
                    <ul>
                        <?php

                        // Loop through rows.
                        while (have_rows('amenities_list')) : the_row();

                            // Load sub field value.
                            $sub_value_amenities = get_sub_field('amenities_item');

                        ?>
                            <div class="amenities-card-content">
                                <li>

                                    <?php echo $sub_value_amenities ?>

                                </li>
                            </div>

                    <?php

                        // End loop.
                        endwhile;


                    endif;
                    ?>
                    </ul>

                </section>

            <section class='tab-pane' id="rates">
                <?php
                // Check rows exists.
                if (have_rows('rates_table')) : ?>
                    <div class="rates-table">
                        <h3>Rates</h3>
                        <table style="text-align: left">
                            <tbody>
                                <?php

                                // Loop through rows.
                                while (have_rows('rates_table')) : the_row();

                                    // Load sub field value.
                                    $sub_value_rates_date = get_sub_field('rates_date_range');
                                    $sub_value_rates_price = get_sub_field('rates_price');
                                ?>
                                    <tr>
                                        <th><?php echo $sub_value_rates_date ?></th>


                                    </tr>
                                    <tr>
                                        <td>$<?php echo $sub_value_rates_price ?>/per night</td>
                                    </tr>

                            <?php

                                // End loop.
                                endwhile;

                            // No value.


                            endif;

                            ?>
                            </tbody>
                        </table>
                    </div>

                        </section>
                        </div>
        </div>
    <?php }; ?>