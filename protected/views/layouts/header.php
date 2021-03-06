<title><?php echo CHtml::encode($this->pageTitle); ?></title>
  
  <script id="template-float-panel" type="text/x-jquery-tmpl">
  <div class="ui-widget ui-dialog ui-corner-all ui-widget-content float-panel no-select">
    <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix">
      <span class="ui-dialog-title">${title}</span>
      <a class="ui-dialog-titlebar-close ui-corner-all" href="#" role="button">
        <span class="ui-icon"></span>
      </a>
    </div>
    <div class="ui-dialog-content ui-widget-content">
    </div>
  </div>
  </script>

  <script id="template-notification" type="text/x-jquery-tmpl">
  <div class="notification">
    {{if closeButton}}
    <a href="#" class="close-button">x</a>
    {{/if}}
    {{if title}}
    <h1 class="title">{{html title}}</h1>
    {{/if}}
    <div class="content">{{html content}}</div>
  </div>
  </script>

  <script id="template-open-table-item" type="text/x-jquery-tmpl">
  <tr>
    <td><a class="title" href="#">${title}</a></td>
    <td>${$item.format(dates.modified)}</td>
    <td><a class="delete" href="#">delete</a></td>
  </tr>
  </script>

  <script id="template-open" type="text/x-jquery-tmpl">
  <div id="open-dialog" class="file-dialog" title="Open mind map">
    <h1><span class="highlight">New!</span> From the Cloud: Dropbox and more</h1>
    <p>Open, save and share your mind maps online in your favorite cloud storage. Supports Google Drive, Dropbox and more! Powered by <a href="http://www.filepicker.io" target="_blank">filepicker.io</a>.</p>
    <button id="button-open-cloud">Open</button>
    <span class="cloud-loading">Loading...</span>
    <span class="cloud-error error"></span>
    <div class="seperator"></div>
    <h1>Local Storage</h1>
    <p>This is a list of all mind maps that are saved in your browser's local storage. Click on the title of a map to open it.</p>
    <table class="localstorage-filelist">
      <thead>
        <tr>
          <th class="title">Title</th>
          <th class="modified">Last Modified</th>
          <th class="delete"></th>
        </tr>
      </thead>
      <tbody class="document-list"></tbody>
    </table>
    <div class="seperator"></div>
    <h1>From file</h1>
    <p>Choose a mind map from your computer's hard drive.</p>
    <div class="file-chooser">
      <input type="file" />
    </div>
  </div>
  </script>

  <script id="template-save" type="text/x-jquery-tmpl">
  <div id="save-dialog" class="file-dialog" title="Save mind map">
    <h1><span class="highlight">New!</span> In the Cloud: Dropbox and more</h1>
    <p>Open, save and share your mind maps online in your favorite cloud storage. Supports Google Drive, Dropbox and more! Powered by <a href="http://www.filepicker.io" target="_blank">filepicker.io</a>.</p>
    <button id="button-save-cloudstorage">Save</button>
    <span class="cloud-error error"></span>
    <div class="seperator"></div>
    <h1>Local Storage</h1>
    <p>You can save your mind map in your browsers local storage. Be aware that this is still experimental: the space is limited and there is no guarantee that the browser will keep this document forever. Useful for frequent backups in combination with cloud storage.</p>
    <button id="button-save-localstorage">Save</button>
    <input type="checkbox" class="autosave" id="checkbox-autosave-localstorage">
    <label for="checkbox-autosave-localstorage">Save automatically every minute.</label>
    <div class="seperator"></div>
    <h1>To file</h1>
    <p>Save the mind map as a file on your computer.</p>
    <div id="button-save-hdd">Save</div>
  </div>
  </script>

  <script id="template-navigator" type="text/x-jquery-tmpl">
  <div id="navigator">
    <div class="active">
      <div id="navi-content">
        <div id="navi-canvas-wrapper">
          <canvas id="navi-canvas"></canvas>
          <div id="navi-canvas-overlay"></div>
        </div>
        <div id="navi-controls">
          <span id="navi-zoom-level"></span>
          <div class="button-zoom" id="button-navi-zoom-out"></div>
          <div id="navi-slider"></div>
          <div class="button-zoom" id="button-navi-zoom-in"></div>
        </div>
      </div>
    </div>
    <div class="inactive">
    </div>
  </div>
  </script>


  <script id="template-inspector" type="text/x-jquery-tmpl">
  <div id="inspector">
    <div id="inspector-content">
      <table id="inspector-table">
        <tr>
          <td>Font size:</td>
          <td><div
              class="buttonset buttons-very-small buttons-less-padding">
              <button id="inspector-button-font-size-decrease">A-</button>
              <button id="inspector-button-font-size-increase">A+</button>
            </div></td>
        </tr>
        <tr>
          <td>Font style:</td>
          <td><div
              class="font-styles buttonset buttons-very-small buttons-less-padding">
              <input type="checkbox" id="inspector-checkbox-font-bold" /> 
              <label
              for="inspector-checkbox-font-bold" id="inspector-label-font-bold">B</label>
                
              <input type="checkbox" id="inspector-checkbox-font-italic" /> 
              <label
              for="inspector-checkbox-font-italic" id="inspector-label-font-italic">I</label> 
              
              <input
              type="checkbox" id="inspector-checkbox-font-underline" /> 
              <label
              for="inspector-checkbox-font-underline" id="inspector-label-font-underline">U</label> 
              
              <input
              type="checkbox" id="inspector-checkbox-font-linethrough" />
               <label
              for="inspector-checkbox-font-linethrough" id="inspector-label-font-linethrough">S</label>
            </div>
          </td>
        </tr>
        <tr>
          <td>Font color:</td>
          <td><input type="hidden" id="inspector-font-color-picker"
            class="colorpicker" /></td>
        </tr>
        <tr>
          <td>Branch color:</td>
          <td><input type="hidden" id="inspector-branch-color-picker"
            class="colorpicker" />
            <button id="inspector-button-branch-color-children" title="Apply branch color to all children" class="right buttons-small buttons-less-padding">Inherit</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
  </script>

  <script id="template-export-map" type="text/x-jquery-tmpl">
  <div id="export-map-dialog" title="Export mind map">
    <h2 class='image-description'>To download the map right-click the
      image and select "Save Image As"</h2>
    <div id="export-preview"></div>
  </div>
  </script>