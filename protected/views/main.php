<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <title>Парсер логов apache</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
<script type="text/x-template" id="grid-template">
      <table>
        <thead>
          <tr>
            <th v-for="key in columns"
              @click="sortBy(key)"
              :class="{ active: sortKey == key }">
              {{ key | cap }}
              <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="entry in filteredlogs">
            <td v-for="key in columns">
              {{entry[key]}}
            </td>
          </tr>
        </tbody>
      </table>
</script>
</head>
<body>
    <div id="app">
        <?php  $this->widget('widgets.auth.AuthWidget'); ?>    
        <div v-if="auth">
            <log-grid :logs="gridData" :columns="gridColumns"></log-grid> 
        </div>
        <h3 v-else>Контент доступен только авторизованным пользователям</h3>
    </div>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vue.js"></script>  
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/axios.min.js"></script>  
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
</body>
</html>