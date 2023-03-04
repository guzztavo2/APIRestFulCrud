<?php

namespace Views;

class view
{
    public string $header;
    public string $footer;
    public const PUBLIC_DIR = 'Views\public\\';
    public const COMPONENTS_DIR = 'Views\public\componentes\\';
    public function __construct()
    {
        $this->header = self::COMPONENTS_DIR . 'header.php';
        $this->footer = self::COMPONENTS_DIR . 'footer.php';
    }


    public function renderPage(string $page, array | null $data = null, string | null $header = null, string | null $footer = null)
    {
        header('content-type: text/html');
        if ($header !== null)
            $this->header = $header;
        if ($footer !== null)
            $this->footer = $footer;
        if ($data !== null)
            extract($data);

        include_once($this->header);

        if (file_exists(self::PUBLIC_DIR . 'paginas\\' . $page))
            include_once(self::PUBLIC_DIR . 'paginas\\' . $page);
        else if (file_exists(self::PUBLIC_DIR . 'paginas\\userViews\\' . $page))
            include_once(self::PUBLIC_DIR . 'paginas\\userViews\\' . $page);
        else if (file_exists(self::PUBLIC_DIR . 'paginas\\appCrud\\' . $page))
            include_once(self::PUBLIC_DIR . 'paginas\\appCrud\\' . $page);
        include_once($this->footer);
    }
}
