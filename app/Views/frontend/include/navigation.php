<!-- <div class="catlogs">
    <ul>
        <?php 

        $url = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
        $sql = "SELECT * FROM nav";
        $nav_out = $conn->query($sql);
        foreach($nav_out as $row)
        {
        ?>
        <li class="<?php //echo ($url === "ZayraKart")? "active": "";?>"><?php echo $row['nav'];?></li>
        <?php } ?> -->
        <!-- <li onclick="ChangeCatlogs('Womens')">Womens</li>
        <li onclick="ChangeCatlogs('Mens')">Mens</li>
        <li onclick="ChangeCatlogs('Kids')">Kids</li>
        <li onclick="ChangeCatlogs('Home & Kitchen')">Home & Kitchen</li>
        <li onclick="ChangeCatlogs('Jewellery & Accessories')">Jewellery & Accessories</li>
        <li onclick="ChangeCatlogs('Electronics')">Electronics</li> -->
        <!-- <li onclick="ChangeCatlogs('Bags & Footwear')">Bags & Footwear</li> -->
        <!-- <li onclick="ChangeCatlogs('Beauty & Health')">Beauty & Health</li> -->
        <!-- <li onclick="ChangeCatlogs('Sports & Fitness')">Sports & Fitness</li> -->
        <!-- <li onclick="ChangeCatlogs('Car & Motorbike')">Car & Motorbike</li> -->
    <!-- </ul>
</div> -->

<style>
  .catlogs {
    background: linear-gradient(to right, #ff9a9e, #fad0c4);
    padding: 1rem 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
  }

  .catlogs ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .catlogs li {
    background-color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    font-weight: 500;
    color: #444;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .catlogs li:hover {
    background-color: #007bff;
    color: white;
    transform: translateY(-2px);
  }

  .catlogs li.active {
    background-color: #ee0979;
    color: white;
    box-shadow: 0 2px 10px rgba(238, 9, 121, 0.4);
  }

  @media (max-width: 576px) {
    .catlogs ul {
      flex-direction: column;
      gap: 0.5rem;
    }

    .catlogs li {
      width: 100%;
      text-align: center;
    }
  }
</style>

<div class="catlogs">
  <ul>
    <?php 
    $url = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    $sql = "SELECT * FROM nav";
    $nav_out = $conn->query($sql);
    foreach($nav_out as $row) {
      $isActive = ($url === strtolower(str_replace(' ', '', $row['nav']))) ? 'active' : '';
    ?>
      <li class="<?= $isActive; ?>" onclick="ChangeCatlogs('<?= $row['nav']; ?>')"><?= $row['nav']; ?></li>
    <?php } ?>
  </ul>
</div>
