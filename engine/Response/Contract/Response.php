<?php

namespace InstaSave\Response\Contract;

interface Response
{
    /**
     * Parse object that comes from Instagram Response to InstaSave Entity Classes.
     *
     * @return Response
     */
    public function parse();
}